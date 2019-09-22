<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::resource('domains', 'DomainsController');

    Route::resource('domains.objects', 'DomainObjectsController', [
        'only' => ['index', 'show'],
    ]);

    Route::resource('domains.objects.attributes', 'DomainObjectAttributesController', [
        'only' => ['index', 'show'],
    ]);

    Route::resource('domains.objects.changes', 'DomainObjectChangesController', [
        'only' => ['index', 'show'],
    ]);

});
