<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\Nomer;
use App\Models\Settings;
use App\Models\Reklama;

use Cache;


/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class NomerController extends Controller
{
    /**
     * @return view "backend.newnumber"
     */
    public function newNumber()
    {
        $sett = Settings::find(1);

        $no = new Nomer();
        $no->getNewNumAttr($sett->currnom);

        return view('backend.newnumber', ['nomer' => $no]);
    }

    /**
     * Stores new Nomer in the DB.
     * @return view
     */
    public function storeNumber(Request $request) {
        $this->validate($request, [
            'next' => 'required|integer|min:1',
            'ynum' => 'required|integer|min:1|max:365',
            'data' => 'required'
        ]);

        //save 'newnom' in Settings-table
        $sett = Settings::find(1);
        $sett->newnom = $request->next;
        $sett->save();

        $newNomerId = Nomer::create(['nomgaz' => $request->next, 'nomgod' => $request->ynum, 'datavyh' => $request->data])->id;

        if ($sett->currnom == 0) {return redirect('admin/dashboard');} // for empty DB in the beginning

        $currentNomerId = Nomer::where('nomgaz', $sett->currnom)->first()->id;
        Nomer::copyRekToNewNum($currentNomerId, $newNomerId);

        Session::put(['editNumber'   => $request->next,
                      'editNumberId' => $newNomerId,
                      'statusNumber' => 'Новый']);

        return redirect('admin/dashboard');
    }

    /**
     * @return view 'backend.delnumber'
     */
    public function delNumberPage() {
        $sett = Settings::find(1);

        $oldNum = Nomer::orderBy('id')->first()->nomgaz; // oldest Nomer for deletion
        $newNum = $sett->newnom; // new Nomer for making it current
        $archNum = $sett->currnom; // current Nomer for making it arch

        if (($newNum - $oldNum) < $sett->kolvo) {$oldNum = 0;} // less than Kolvo, in the beginning
        if (($newNum - $oldNum) == 0) {$archNum = 0;} // one record in the Nomer-table, in the beginning (no Nomer for arch)

        return view('backend.delnumber', ['nomer' => $oldNum, 'newnomer' => $newNum, 'arch' => $archNum]);
    }

    /**
     * Remove oldest Nomer from Nomer-table,
     * corresponding reklama-records from Reklama-table,
     * records from pivot kword-reklama-table,
     * unused keywords from kwords-table,
     * unused images from /img directory.
     */
    public function delNumberScript() {
        // change 'curnom' to 'newnom' in settings-table
        $sett = Settings::find(1);

        $sett->currnom = $sett->newnom; // change new Nomer to current Nomer
        $sett->save();

        Session::forget('editNumberId');
        Cache::forget('search');
        Cache::forget('randomId');

        if (Nomer::all()->count() <= $sett->kolvo) {return redirect('admin/dashboard');} // in the beginning or when number of archives increasing

        while (Nomer::all()->count() > $sett->kolvo) {
            Nomer::delOldestNumber();
        }

        Cache::forget('search');
        Cache::forget('randomId');

        // delete image files which don't exist in the DB
        $allDirImages = scandir(public_path() . '/img');
        $allDbImages = Reklama::all()->pluck('rekname');

        $search = ['s.jpg', '.jpg'];

        foreach ($allDirImages as $f) {
            if (is_file(public_path() . '/img/' . $f)) {
                $filename = str_replace($search, '', $f);

                if (!$allDbImages->contains($filename)) {
                    $fileErase = public_path() . '/img/' . $f;
                    if(file_exists($fileErase)){unlink($fileErase);}
                }
            }
        }

        return redirect('admin/dashboard');
    }

} // class NomerController END