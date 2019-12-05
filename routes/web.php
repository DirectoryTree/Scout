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

    Route::group(['prefix' => 'settings', 'namespace' => 'Settings', 'as' => 'settings.'], function () {
        Route::get('/', 'GlobalController@edit')->name('edit');
        Route::patch('/', 'GlobalController@update')->name('update');

        Route::get('/users', 'UsersController@index')->name('users.index');
        Route::get('/users/add', 'UsersController@create')->name('users.create');
        Route::post('/users', 'UsersController@store')->name('users.store');
        Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');
        Route::patch('/users/{user}', 'UsersController@update')->name('users.update');
        Route::delete('/users/{user}', 'UsersController@destroy')->name('users.destroy');

        Route::get('/email', 'EmailController@edit')->name('email.edit');
        Route::patch('/email', 'EmailController@update')->name('email.update');

        Route::post('/generate/scheduler-task', 'GenerateTaskController@scheduler')->name('generate.scheduler');
        Route::post('/generate/queue-task', 'GenerateTaskController@queue')->name('generate.queue');
    });

    Route::get('/notifications',      'NotificationsController@index')->name('notifications.index');
    Route::get('/notifications/{id}', 'NotificationsController@show')->name('notifications.show');

    Route::post('/objects/{object}/pin', 'ObjectPinController@store')->name('objects.pin.store');
    Route::delete('/objects/{object}/pin', 'ObjectPinController@destroy')->name('objects.pin.destroy');

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

    Route::get('/domains/{domain}/notifiers/{notifier}/logs',       'DomainNotifierLogsController@index')->name('domains.notifiers.logs.index');
    Route::get('/domains/{domain}/notifiers/{notifier}/logs/{log}', 'DomainNotifierLogsController@show')->name('domains.notifiers.logs.show');

    Route::get('/domains/{domain}/notifiers/{notifier}/conditions', 'DomainNotifierConditionsController@index')
        ->name('domains.notifiers.conditions.edit');

    Route::patch('/notifiers/{notifier}',  'NotifiersController@update')->name('notifiers.update');
    Route::delete('/notifiers/{notifier}', 'NotifiersController@destroy')->name('notifiers.destroy');

    Route::post('/notifiers/{notifier}/conditions', 'NotifierConditionsController@store')->name('notifiers.conditions.store');

    Route::post('/notifiers/{notifiable_type}/{notifiable_model}', 'NotifierNotifiableController@store')->name('notifiers.notifiable.store');

    Route::patch('/conditions/{condition}', 'ConditionsController@update')->name('conditions.update');
    Route::delete('/conditions/{condition}', 'ConditionsController@destroy')->name('conditions.destroy');

    Route::patch('notifications/mark-all', 'NotificationMarkAllController@update')->name('notifications.mark.all');
    Route::patch('notifications/{notification}/mark', 'NotificationMarkController@update')->name('notifications.mark.update');

    Route::group(['namespace' => 'Partials', 'prefix' => 'partials', 'as' => 'partials.'], function () {
        Route::get('/search', 'SearchController@index')->name('search.index');

        Route::get('domains/{domain}/search', 'DomainSearchController@index')->name('domains.search.index');

        Route::get('domains/{domain}/objects/{object}/tree', 'DomainObjectsTreeController@show')->name('domains.objects.tree.show');
    });

    Route::group(['namespace' => 'Api', 'prefix' => 'api', 'as' => 'api.'], function() {
        Route::patch('notifier/{notifier}', 'NotifierToggleController@update')->name('notifier.toggle');

        Route::get('notifications', 'NotificationsController@index')->name('notifications.index');
    });
});
