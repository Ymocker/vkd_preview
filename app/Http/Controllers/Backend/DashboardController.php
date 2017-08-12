<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use App\Models\Nomer;
use App\Models\Settings;

use Cache;


/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class DashboardController extends Controller
{
    /**
     *
     * @return dashboard view
     */
    public function index()
    {
        // for console output
        // $debug = new PHPDebug();
        // $debug->debug('Simple message to console');
        if (!Session::has('editNumberId')) {
            Session::put('editNumberId', Nomer::max('id'));
        }

        if ((Session::get('editNumberId')) === null)  //for empty database
        {
            $no = new Nomer;

            $no->nomgaz = 1;
            $no->nomgod = 1;
            $no->datavyh = '';
            $no->current = 0;

            $admData['editNumberId'] = 0;
            $admData['editNumber'] = '';
            $admData['statusNumber'] = '';
            $admData['addNewNom'] = ($sett->currnom == $sett->newnom);

            return view('backend.newnumber', ['nomer' => $no]);
        }

        $sett = Settings::find(1);
        $admData['addNewNom'] = ($sett->currnom == $sett->newnom);

        $editNumber = Nomer::find(Session::get('editNumberId'))->nomgaz; // 1025 number
        Session::put('editNumber', $editNumber);

        $results = Nomer::orderBy('id')->get();
        $numbers = array();
        foreach ($results as $r) {
            $numbers[$r->id] = $r->nomgaz;
        }

        $status = $this->changeNumber($editNumber);

        $admData['editNumberId'] = Session::get('editNumberId');
        $admData['editNumber'] = $editNumber;
        $admData['statusNumber'] = $status;

        return view('backend.dashboard', ['numbers' => $numbers, 'admData' => $admData]);
    }

    /**
     * Changes number for editing
     * @param type $num
     * @return string, status of edited number
     */
    public function changeNumber($num = -1) { //change edited number. $num - 1025
        //$_POST['numberId'], $_POST['number'];

        if ($num == -1) { // from dashboard.blade, ajax post
            $num = $_POST['number'];
            Session::put('editNumberId', $_POST['numberId']);
        }

        $results = Settings::find(1);

        if ($num == $results->currnom) {
            $status = 'Текущий';
        } elseif ($num > $results->currnom) {
            $status = 'Новый';
        } else {
            $status = 'Архивный';
        }

        Session::put(['statusNumber' => $status, 'editNumber' => $num]);

        return $status;
    }

    /**
     * @return newtext view for loading and editing text advertising
     */
    public function showTextForm() { // add text advertising form
        $filename = public_path('textrek') . '/' . Session::get('editNumberId') . '.txt';
        if (file_exists($filename)) {
            $txtFile = file_get_contents($filename);
        } else {
            $txtFile = '';
        }

        return view('backend.newtext', ['txtFile' => $txtFile]);
    }

    /**
     * @param Request $request (name of loaded file)
     * Stores loaded file
     */
    public function storeText(Request $request) {
        $request->file('file_name')->move(public_path('textrek'), Session::get('editNumberId') . '.txt');
        return redirect('admin/addtext');
    }

    /**
     * @param Request $request (text from textarea) using ajax
     * Saves changes of text in the textarea
     */
    public function saveText(Request $request) {
        $filename = public_path('textrek') . '/' . Session::get('editNumberId') . '.txt';
        $handle = fopen($filename, "w");
        fwrite($handle, $request->input('txt'));
        fclose($handle);

        return $request->input('txt');
    }

    /**
     * @return settings view
     */
    public function showSettings() {
        $sett = Settings::find(1);

        return view('backend.settings', ['sett' => $sett]);
    }

    /**
     * Store settings in the DB
     * @param Request $request
     */
    public function saveSettings(Request $request) {
        $sett = Settings::find(1);

        $sett->currnom = $request->currnom;
        $sett->newnom = $request->newnom;
        $sett->kolvo = $request->kolvo;
        $sett->ksdelimiter = $request->ksdelimiter;
        $sett->smallpic = $request->smallpic;
        $sett->actia = $request->actia;

        $sett->save();
        Cache::forget('search');
        Cache::forget('randomId');

        return redirect('admin/settings');
    }

    /**
     * auxiliary function to calculate bcrypt cipher for a string
     * @param Request $request (string in the input field)
     */
    public function cipher(Request $request) {
        return bcrypt($request->input('pass'));
    }

    public function showAbout(Request $request) {
        $filename = public_path('textrek') . '/' . $request->input('file') . '.txt';
        if (file_exists($filename)) {
            $txtFile = file_get_contents($filename);
        } else {
            $txtFile = '';
        }

        return $txtFile;
    }

    public function saveAbout(Request $request) {
        $filename = public_path('textrek') . '/' . $request->input('file');
        $handle = fopen($filename, "w");
        fwrite($handle, $request->input('txt'));
        fclose($handle);

        return $request->input('file');
    }

    public function showSecure() {
        $adm = DB::table('users')->where('name', 'Administrator')->first();
        return view('backend.secure', ['admail' => $adm->email]);
    }

    public function saveSecure(Request $request) {
        DB::table('users')
            ->where('name', 'Administrator')
            ->update(['email' => $request->adminemail, 'password' => bcrypt($request->pass)]);

        return redirect('admin/dashboard');
    }

} // class DashboardController END

//$start = microtime(true);
//echo 'Время выполнения скрипта: '.(microtime(true) - $start).' сек.';