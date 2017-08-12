<?php

/*
 * Frontend Routes
 * Namespaces indicate folder structure
 */

Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    require __DIR__.'/Frontend/Frontend.php';
    require __DIR__.'/Frontend/Access.php';
});

/* ----------------------------------------------------------------------- */

/*
 * Backend Routes
 * Namespaces indicate folder structure
 */

Route::group(['namespace' => 'Frontend\Auth'], function () {
    Route::get('admin/login', ['as' => 'login', 'uses' => 'LoginController@showLoginForm']);
    Route::post('admin/login', ['as' => 'login.post', 'uses' => 'LoginController@login']);

    Route::get('password/reset', ['as' => 'password.reset', 'uses' => 'ForgotPasswordController@showLinkRequestForm']);
    Route::post('password/email', ['as' => 'password.email', 'uses' => 'ForgotPasswordController@sendResetLinkEmail']);
    Route::get('password/reset/{token}', ['as' => 'password.reset.token', 'uses' => 'ResetPasswordController@showResetForm']);
    Route::post('password/reset', ['as' => 'password.reset.post', 'uses' => 'ResetPasswordController@reset']);
});

Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth'], function () {
    /*
     * These routes need view-backend permission
     * (good if you want to allow more than one group in the backend,
     * then limit the backend features by different roles or permissions)
     *
     * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
     */
    require (__DIR__.'/Backend/Backend.php');

});
