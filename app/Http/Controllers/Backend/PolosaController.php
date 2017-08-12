<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Session;
use App\Models\Reklama;


/**
 * Class PolosaController
 * @package App\Http\Controllers\Backend
 */
class PolosaController extends Controller
{
    /**
     * @param string $p
     * @return polosa.view (999 for archive ads)
     */
    public function viewPolosa($p = 1)
    {
        if ($p == 999) {
            $results = Reklama::where('polosa', '>=', 90)->orderBy('id')->get();
        } else {
            $results = Reklama::nomer(Session::get('editNumberId'))->where('polosa', $p)->orderBy('id')->get();
        }

        return view('backend.polosa', ['reklama' => $results, 'polosa' => $p]);
    }

} // class PolosaController END