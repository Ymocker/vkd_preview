<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

use App\Models\Settings;
use App\Models\Nomer;

use Closure;

class AdminData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*Session
         * editNumberId
         * editNumber
         * statusNumber
        */
        if (!Session::has('editNumberId')) {return redirect('admin/dashboard');}

        $admData = collect();

        $admData->put('editNumberId', Session::get('editNumberId'));
        $admData->put('editNumber', Session::get('editNumber'));
        $admData->put('statusNumber', Session::get('statusNumber'));

        $sett = Settings::find(1);
        $admData->put('wd', $sett->smallpic);

        $addNom = ($sett->currnom == $sett->newnom);
        $admData->put('addNewNom', $addNom);

        View::share('admData', $admData);

        return $next($request);
    }
}
