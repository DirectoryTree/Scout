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

Route::group(['middleware' => 'can.install'], function () {

    Route::get('install', 'InstallController@index')->name('install.index');
    Route::post('install', 'InstallController@store')->name('install.store');
    Route::post('install/migrate', 'InstallController@migrate')->name('install.migrate');

});

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::resource('domains', 'DomainsController');

    Route::get('/domains/{domain}/delete', 'DomainsController@delete')->name('domains.delete');

    Route::post('/domains/{domain}/synchronize', 'DomainsController@synchronize')->name('domains.synchronize');

    Route::get('/domains/{domain}/search', 'DomainSearchController@index')->name('domains.search.index');

    Route::resource('domains.notifiers', 'DomainNotifiersController');

    Route::resource('domains.scans', 'DomainScansController', [
        'only' => ['index', 'show'],
    ]);

    Route::resource('domains.changes', 'DomainChangesController', [
        'only' => ['index', 'show'],
    ]);

    Route::resource('domains.objects', 'DomainObjectsController', [
        'only' => ['index', 'show'],
    ]);

    Route::patch('domains/{domain}/objects/{object}/sync', 'DomainObjectsController@sync')
        ->name('domains.objects.sync');

    Route::resource('domains.objects.attributes', 'DomainObjectAttributesController', [
        'only' => ['index', 'show'],
    ]);

    Route::resource('domains.objects.changes', 'DomainObjectChangesController', [
        'only' => ['index', 'show'],
    ]);

    Route::group(['namespace' => 'Api', 'prefix' => 'api', 'as' => 'api.'], function() {

        Route::get('notifications', 'NotificationsController@index')->name('notifications');

    });

});
