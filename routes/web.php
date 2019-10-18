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

    Route::get('/install',           'InstallController@index')->name('install.index');
    Route::post('/install',          'InstallController@store')->name('install.store');
    Route::post('/install/migrate',  'InstallController@migrate')->name('install.migrate');

});

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::get('/notifications',      'NotificationsController@index')->name('notifications.index');
    Route::get('/notifications/{id}', 'NotificationsController@show')->name('notifications.show');

    Route::get('/domains',                 'DomainsController@index')->name('domains.index');
    Route::get('/domains/add',             'DomainsController@create')->name('domains.create');
    Route::post('/domains',                'DomainsController@store')->name('domains.store');
    Route::get('/domains/{domain}',        'DomainsController@show')->name('domains.show');
    Route::get('/domains/{domain}/edit',   'DomainsController@edit')->name('domains.edit');
    Route::patch('/domains/{domain}',      'DomainsController@update')->name('domains.update');
    Route::delete('/domains/{domain}',     'DomainsController@destroy')->name('domains.destroy');
    Route::get('/domains/{domain}/delete', 'DomainsController@delete')->name('domains.delete');

    Route::get('/domains/{domain}/changes',          'DomainChangesController@index')->name('domains.changes.index');
    Route::get('/domains/{domain}/changes/{change}', 'DomainChangesController@show')->name('domains.changes.show');

    Route::get('/domains/{domain}/objects',          'DomainObjectsController@index')->name('domains.objects.index');
    Route::get('/domains/{domain}/objects/{object}', 'DomainObjectsController@show')->name('domains.objects.show');

    Route::get('/domains/{domain}/objects/{object}/changes', 'DomainObjectChangesController@index')
        ->name('domains.objects.changes.index');
    Route::get('/domains/{domain}/objects/{object}/changes/{change}', 'DomainObjectChangesController@show')
        ->name('domains.objects.changes.show');

    Route::get('/domains/{domain}/objects/{object}/attributes', 'DomainObjectAttributesController@index')
        ->name('domains.objects.attributes.index');

    Route::post('/domains/{domain}/synchronize', 'DomainSyncController@store')->name('domains.synchronize');

    Route::get('/domains/{domain}/search', 'DomainSearchController@index')->name('domains.search.index');

    Route::get('/domains/{domain}/scans', 'DomainScansController@index')->name('domains.scans.index');

    Route::get('/domains/{domain}/notifiers',                 'DomainNotifiersController@index')->name('domains.notifiers.index');
    Route::get('/domains/{domain}/notifiers/new',             'DomainNotifiersController@create')->name('domains.notifiers.create');
    Route::get('/domains/{domain}/notifiers/{notifier}',      'DomainNotifiersController@show')->name('domains.notifiers.show');
    Route::get('/domains/{domain}/notifiers/{notifier}/edit', 'DomainNotifiersController@edit')->name('domains.notifiers.edit');

    Route::patch('/notifiers/{notifier}',  'NotifiersController@update')->name('notifiers.update');
    Route::delete('/notifiers/{notifier}', 'NotifiersController@destroy')->name('notifiers.destroy');

    Route::post('/notifiers/{notifier}/conditions', 'NotifierConditionsController@store')->name('notifiers.conditions.store');

    Route::post('/notifiers/{notifiable_type}/{notifiable_model}', 'NotifierNotifiableController@store')->name('notifiers.notifiable.store');

    Route::patch('/conditions/{condition}', 'ConditionsController@update')->name('conditions.update');
    Route::delete('/conditions/{condition}', 'ConditionsController@destory')->name('conditions.destroy');

    Route::patch('domains/{domain}/objects/{object}/sync', 'DomainObjectSyncController@update')
        ->name('domains.objects.sync');

    Route::group(['namespace' => 'Api', 'prefix' => 'api', 'as' => 'api.'], function() {

        Route::patch('notifier/{notifier}', 'NotifierToggleController@update')->name('notifier.toggle');

        Route::get('notifications', 'NotificationsController@index')->name('notifications.index');
        Route::patch('notifications/{notification}/mark', 'NotificationMarkController@update')->name('notifications.mark.update');

    });

});
