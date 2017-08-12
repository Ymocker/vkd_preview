<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Nomer;
use App\Models\Settings;
use App\Models\Reklama;
use App\Models\Kword;

use Cache;


/**
 * Class ReklamaController
 * @package App\Http\Controllers\Backend
 */
class ReklamaController extends Controller
{
    /**
     * Returns view backend.newrek for adding new Reklama-record
     * @return view backend.newrek || backend.newnumber
     */
    public function newRek() {
        if (Nomer::all()->count() == 0) { // for empty database in the begining
            $no = new Nomer;

            $no->nomgaz = 1;
            $no->nomgod = 1;
            $no->datavyh = '';
            $no->current = 0;

            $admData['editNumberId'] = 0;
            $admData['editNumber'] = '';
            $admData['statusNumber'] = '';

            return view('backend.newnumber', ['nomer' => $no]);
        }

        $kw = Kword::orderBy('kword')->pluck('kword', 'id')->all(); // array of keywords with IDs
        $delimiter = Settings::find(1)->pluck('ksdelimiter')->first();

        return view('backend.newrek', ['kw' => $kw, 'delimiter' => $delimiter]);
    }

    /**
     * Uploads image file to temporary directory.
     * Is called from backend.newrek.blade (ajax upload)
     */
    public function picUpload() {
        $source = $_FILES['userfile']['tmp_name'];
        if ($source == '') {exit();}

        $fileInfo = array('name'=>$_FILES['userfile']['name'],
                          'size'=>$_FILES['userfile']['size'],
                          'type'=>$_FILES['userfile']['type']
                        );

        $tmpFilePath = public_path() . '/img/tmp/';
        //$tmpFileName = time() . '-' . $_FILES['userfile']['name'];
        $info = pathinfo($_FILES['userfile']['name']);
        //$debug->debug($tmpFilePath . 'work.' . $info['extension']));
        move_uploaded_file($source, $tmpFilePath . 'work.' . $info['extension']);

        $size = getimagesize($tmpFilePath . 'work.' . $info['extension']);

        $fileInfo['ext'] = $info['extension'];
        $fileInfo['dimensions'] = $size[3];

        die(json_encode($fileInfo));
    }

    /**
     * Stores Reklama-record in the DB.
     * @param Request $request
     */
    public function storeRek(Request $request) {
        $this->validate($request, [
            'name' => 'required|max:20',
            //'razmer' => 'required|integer|min:400|max:2000',
            'polosa' => 'required|integer|min:0|max:9'
        ]);

        $newRek = new Reklama();
        $newRek->store($request);

        $keywords = new Kword();
        $allKw = $keywords->store($request);

        $newRek->kwords()->attach($allKw); // add info to pivot table

        Cache::forget('search');

        return redirect('admin/add');
    }

    public function editRek($id) {

        exit('edit ' . $id);
    }

    /**
     * place Reklama with ID = $id in/from archive (polosa = 9* for archive)
     * @param integer $id
     * @param $p - polosa from which was made the call
     * @return polosa.view
     */
    public function archRek($id, $p) { //
        $rek = Reklama::findOrFail($id);

        if ($p != 999) { // p=999 for archive polosa.blade
            $rek->reklamaToArch();
        } else {
            $rek->reklamaFromArch();
        }

        Cache::forget('search');

        return redirect('admin/polosa/' . $p);
    }

    /**
     * Deletes Reklama-record with ID=$id
     * @param integer $id
     * @param $p - polosa from which was made the call
     */
    public function destroyRek($id, $p) {
        $rek = Reklama::findOrFail($id);
        $rek->destroyRek();

        Cache::forget('search');

        return redirect('admin/polosa/' . $p);
    }

} // class ReklamaController END