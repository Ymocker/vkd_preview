<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use App\Models\Nomer;
use App\Models\Settings;
use Closure;
use Cache;

class VerifyTop
{
    /**
     * Handle an incoming request.
     * Check if session has Selected Number which is showed to user.
     * If it has not, assign the last number to Selected Number
     *
     * Make random integer 1-20 for selecting background picture
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Session::has('numberGod')) {
            $currNom = Settings::find(1)->currnom;
            $nomer = Nomer::where('nomgaz', $currNom)->first();
            $back = rand(1, 20);
            Session::put(['numberId' => $nomer->id, 'numberGod' => $nomer->nomgod,
                'numberGaz' => $nomer->nomgaz, 'dataVyh' => $nomer->datavyh, 'back' => $back]);
        }

        //'nomgaz, nomgod, nomId, datavyh' - current issue data for several views
        $viewData = collect();

        $viewData->put('nomgaz', Session::get('numberGaz'));
        $viewData->put('nomgod', Session::get('numberGod'));
        $viewData->put('datavyh', Session::get('dataVyh'));
        $viewData->put('nomId', Session::get('numberId'));

        $informer = Cache::remember('informer', 60, function() {
            ob_start();
            require resource_path() . '/views/frontend/includes/informer.blade.php';
            $informer = ob_get_contents();
            ob_end_clean();

            return $informer;
        });

        $viewData->put('informer', $informer);

        View::share('viewData', $viewData);

        return $next($request);
    }
}