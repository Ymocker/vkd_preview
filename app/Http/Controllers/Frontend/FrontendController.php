<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Reklama;
use App\Models\Nomer;
use App\Models\Settings;
use App\Models\Kword;

use Mail;
use Cache;

/**
 * Class FrontendController
 * @package App\Http\Controllers
 */
class FrontendController extends Controller
{
    /**
     * @param string $p
     * @return frontend.index view - main page of the site.
     * It depends of argument $p
     */
    public function index($p = 1)
    {
        switch ($p) {
            case '0':
                $section = 'Реклама&nbsp;на&nbsp;сайте';
                break;
            case '2':
                $section = 'Реклама&nbsp;на&nbsp;внутренних&nbsp;полосах';
                break;
            case '4':
                $section = 'Реклама&nbsp;на&nbsp;последней&nbsp;полосе';
                break;
            case '5':
                $section = 'Текстовая&nbsp;реклама';
                break;
            case 'search':
                $section = 'Поиск&nbsp;рекламы';
                break;
            default:
                $section = 'Реклама&nbsp;на&nbsp;первой&nbsp;полосе';
                $p = '1';
        }

        $sett = Settings::find(1);
        $width = $sett->smallpic; //get dimension for thumbnails
        $actia = $sett->actia;

        $randRekId = Reklama::randomRekId($sett->currnom);
        $randRek = Reklama::findOrFail($randRekId);

        /**
         * get $result for view:
         * advertising, text ads or search page
         */
        if ($p == '5') { // text ads
            $results = file_get_contents(public_path() . '/textrek/' . Session::get('numberId') . '.txt');
        } elseif ($p == 'search') {  // search page
            if (Cache::has('search')) {
                $results = Cache::get('search');
            } else {
                $newNom = Nomer::where('nomgaz', $sett->currnom)->first()->id;

                $resultColl = Reklama::select('id')->where('polosa', '<', 90)
                        ->where('nomer_id', '<=', $newNom)
                        ->with('kwords')->get();

                $results = collect([]);
                foreach ($resultColl as $rek) {
                    $results = $results->merge($rek->kwords);
                }

                $resultColl = $results->unique('id')->sortBy('kword');

                $results = collect([]);
                foreach ($resultColl as $rek) {
                    $results->push(['id' => $rek->id, 'kword' => $rek->kword]);
                }
                Cache::forever('search', $results);
            }

            $width = ceil($results->count()/3); // number of keywords in one div of 3
        } else { // advertising blocks
            $results = Reklama::nomer(Session::get('numberId'))->where('polosa', $p)->get()->shuffle();
        }

        //'reklama' - result for index view, 'wd' - width of the thumbnail,
        //'numbers' - array of id and value for issue selecting,
        return view('frontend.index', ['reklama' => $results,
            'wd' => $width,
            'numbers' => Nomer::archNumbers(),
            'section' => $section,
            'actia' => $actia,
            'randRek' => $randRek]);
    }

    /**
     *
     * @param type $no
     * @param type $page
     * @return type
     */
//    public function page($no, $page = 1)
//    {
//        //page 0, 1, 2, 4 - block adv.
//        //page 5 - text adv.
//
//        return view('frontend.page')->with('page', $page);
//    }

    /**
     * @param type $id
     * @return frontend.ads view for ad with selected ID
     */
    public function getAd($id = '')
    {
        if ($id === '')
            {return redirect('/');}

        $rek = Reklama::findOrFail($id);
        $nomer = Nomer::find($rek->nomer_id);
        return view('frontend.ads', ['reklama' => $rek, 'nomer' => $nomer]);
    }

    /**
     * @param type $num
     * @return index view
     * Changes current issue number (issue number from archive) and place it to the Session
     */
    public function changeNum($num)
    {
        $nomer = Nomer::findOrFail($num);

        Session::put(['numberId' => $num, 'numberGod' => $nomer->nomgod,
            'numberGaz' => $nomer->nomgaz, 'dataVyh' => $nomer->datavyh]);
        return redirect('/');
    }

    /**
     * @param string $id
     * @return about.view
     */
    public function aboutView($id = 'about') {
        switch ($id) {
            case 'contact':
                $data = file_get_contents(public_path() . '/textrek/contact.txt');
                $backform = true;
                break;
            case 'tariff':
                $data = file_get_contents(public_path() . '/textrek/tariff.txt');
                $backform = false;
                break;
            default:
                $data = file_get_contents(public_path() . '/textrek/about.txt');
                $backform = false;
        }
        return view('frontend.about', ['data' => $data, 'backform' => $backform]);
    }

    /**
     * @param integer $kwId - ID of selected keyword
     * @return search results with index view
     */
    public function searchResult($kwId) {
        $sett = Settings::find(1);

        $curNomId = Nomer::where('nomgaz', $sett->currnom)->first()->id;
        $searchResult = Kword::findOrFail($kwId)->reklamas()->where('polosa', '<', '90')
                                                            ->where('nomer_id', '<=', $curNomId) //exclude new edited Nomer
                                                            ->orderBy('id','desc')->get();
        $results = $searchResult->unique('rekname');

        $width = $sett->smallpic; //get dimension for thumbnails
        $actia = $sett->actia;

        $randRekId = Reklama::randomRekId($sett->currnom);
        $randRek = Reklama::findOrFail($randRekId);

        $section = 'Результаты поиска рекламы «' . Kword::find($kwId)->kword . '»';

        return view('frontend.index', [
            'reklama' => $results,
            'wd' => $width,
            'numbers' => Nomer::archNumbers(),
            'section' => $section,
            'actia' => $actia,
            'randRek' => $randRek]);
    }

    /**
     * send message from site
     */
    public function sendMessage(Request $request) {
        $msg = 'Имя: ' . $request->name . '<br />';
        $msg .= 'Телефон: ' . $request->phone . '<br />';
        $msg .= 'E-mail: ' . $request->email . '<br />';
        $msg .= 'Сообщение: ' . $request->message . '<br />';
        //$msg = 'Content-type: text/plain; charset=utf-8' . PHP_EOL;
        //$msg .= 'From: ' . $request->email . PHP_EOL;

        Mail::send('emails.fromsite', array('msg' => $msg), function($message) use ($request)
        {
            $message->to(env('MAIL_TO_FROM_SITE'))
                    ->subject('Заказ обратного звонка(сообщения) с сайта')
                    ->from('post@vkd.by', 'Post robot');
        });

        return 'Сообщение отправлено';
    }

}
