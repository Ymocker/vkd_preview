<?php

/**
 * Frontend Controllers
 */

Route::group(['middleware' => 'verifyTop'], function () {
    Route::get('/', 'FrontendController@index')->name('index');
    Route::get('/page/{id?}', 'FrontendController@index');
    Route::get('/search/{kw}', 'FrontendController@searchResult');
});

Route::get('/number/{id}', 'FrontendController@changeNum');
Route::get('/ads/{id?}', 'FrontendController@getAd');
Route::get('/about/{id?}', 'FrontendController@aboutView');
Route::post('/about/send/message', 'FrontendController@sendMessage');


/**
 * These frontend controllers require the user to be logged in
 */
//Route::group(['middleware' => 'auth'], function () {
//    Route::group(['namespace' => 'User'], function() {
//        Route::get('dashboard', 'DashboardController@index')->name('frontend.user.dashboard');
//        Route::get('profile/edit', 'ProfileController@edit')->name('frontend.user.profile.edit');
//        Route::patch('profile/update', 'ProfileController@update')->name('frontend.user.profile.update');
//    });
//});