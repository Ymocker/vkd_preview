<?php

Route::group(['namespace' => 'Auth', 'as' => 'auth.'], function () {

    Route::group(['middleware' => 'auth'], function () {
        Route::get('admin/register', ['as' => 'register', 'uses' => 'RegisterController@showRegistrationForm']);
        Route::post('admin/register', ['as' => 'register.post', 'uses' => 'RegisterController@register']);

        Route::get('admin/logout', ['as' => 'logout', 'uses' => 'LoginController@logout']);
    });
});





