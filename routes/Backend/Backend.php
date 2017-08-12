<?php
/**
* All route names are prefixed with 'admin'
*/

Route::get('dashboard', 'DashboardController@index')->name('dashboard');
Route::post('changenumber', 'DashboardController@changeNumber')->name('changenumber');
Route::post('newnumber', 'NomerController@storeNumber')->name('storenumber');
Route::post('add', 'ReklamaController@storeRek')->name('storerek');
Route::post('rek/{id}/edit', 'ReklamaController@update');
Route::post('picupload', 'ReklamaController@picUpload')->name('picupload');
Route::post('addtext', 'DashboardController@storeText');
Route::post('settings', 'DashboardController@saveSettings');
Route::get('cipher', 'DashboardController@cipher');
Route::get('about', 'DashboardController@showAbout');
Route::post('saveabout', 'DashboardController@saveAbout');
Route::post('savetext', 'DashboardController@saveText');
Route::post('security', 'DashboardController@saveSecure');

Route::group(['middleware' => 'adminData'], function () {
    Route::get('newnumber', 'NomerController@newNumber')->name('newnumber');
    Route::get('delnumber', 'NomerController@delNumberPage')->name('delnumber');
    Route::get('delnumberscript', 'NomerController@delNumberScript')->name('delnumberscript');
    Route::get('polosa/{id}', 'PolosaController@viewPolosa')->name('polosa');
    Route::get('add', 'ReklamaController@newRek')->name('newrek');
    Route::get('rek/{id}/edit', 'ReklamaController@editRek');
    Route::get('rek/{id}/arch/{p}', 'ReklamaController@archRek');
    Route::get('rek/{id}/delete/{p}', 'ReklamaController@destroyRek');
    Route::get('addtext', 'DashboardController@showTextForm')->name('showtext');
    Route::get('settings', 'DashboardController@showSettings')->name('settings');
    Route::get('security', 'DashboardController@showSecure')->name('security');
});