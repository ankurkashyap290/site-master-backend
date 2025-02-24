<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Config')
    ->group(function () {
        Route::get('config', 'ConfigController@index')->name('config.index');
    });

Route::namespace('Auth')
    ->prefix('auth')
    ->group(function () {
        Route::post('login', 'AuthController@login')->name('auth.login');
        Route::post('forgot-password', 'ForgotPasswordController@sendResetLinkEmail')->name('auth.forgot-password');
        Route::post('reset-password', 'ForgotPasswordController@resetPassword')->name('auth.reset-password');
        Route::group(['middleware' => ['api', 'jwt.auth']], function () {
            Route::post('logout', 'AuthController@logout');
            Route::post('refresh', 'AuthController@refresh');
            Route::get('me', 'AuthController@getUser');
            Route::post('change-password', 'ChangePasswordController@changePassword')->name('auth.change-password');
        });
    });

Route::namespace('Auth')
    ->prefix('activation')
    ->group(function () {
        Route::post('activable-user', 'ActivationController@getActivableUser');
        Route::post('activate-user', 'ActivationController@activateUser');
    });

Route::namespace('Organization')
    ->middleware(['api', 'jwt.auth'])
    ->group(function () {
        Route::resource('organizations', 'OrganizationController')
        ->except([
            'create',
            'edit',
        ])
        ->parameters([
            'organizations' => 'id'
        ]);

        Route::resource('facilities', 'FacilityController')
        ->except([
            'create',
            'edit',
        ])
        ->parameters([
            'facilities' => 'id'
        ]);
    });

Route::namespace('Location')
    ->middleware(['api', 'jwt.auth', 'scopes'])
    ->group(function () {
        Route::resource('locations', 'LocationController')
        ->except([
            'create',
            'edit',
        ])
        ->parameters([
            'locations' => 'id'
        ]);
        Route::post('locations/import', 'LocationController@import')->name('locations.import');
    });

Route::namespace('User')
    ->middleware(['api', 'jwt.auth', 'scopes'])
    ->group(function () {
        Route::resource('users', 'UserController')
            ->except([
                'create',
                'edit',
            ])
            ->parameters([
                'users' => 'id'
            ]);
        Route::put('users/reset-password/{id}', 'UserController@resetPassword')->name('users.resetPassword');

        Route::resource('policies', 'PolicyController')
            ->except([
                'create',
                'delete',
            ])
            ->parameters([
                'policies' => 'id'
            ]);
    });

Route::namespace('Client')
    ->middleware(['api', 'jwt.auth', 'scopes'])
    ->group(function () {
        Route::resource('clients', 'ClientController')
            ->except([
                'create',
                'edit',
            ])
            ->parameters([
                'clients' => 'id'
            ]);
        Route::post('clients/import', 'ClientController@import')->name('clients.import');
    });

Route::namespace('Logs')
    ->middleware(['api', 'scopes'])
    ->group(function () {
        Route::resource('transport-logs', 'TransportLogController')
            ->except([
                'create',
                'edit',
            ])
            ->parameters([
                'transport-logs' => 'id'
            ]);

        Route::resource('transport-billing-logs', 'TransportBillingLogController')
            ->except([
                'create',
                'edit',
            ])
            ->parameters([
                'transport-billing-logs' => 'id'
            ]);
    });

Route::namespace('Event')
    ->middleware(['api', 'jwt.auth', 'scopes'])
    ->group(function () {
        Route::resource('events', 'EventController')
            ->except([
                'create',
                'edit',
            ]);

        Route::get('bidding', 'BiddingController@index')
            ->name('bidding.index');
        Route::post('bidding/assign-drivers/{event_id}', 'BiddingController@assignDrivers')
            ->name('bidding.assign-drivers');
        Route::delete('bidding/decline-all-drivers/{event_id}', 'BiddingController@declineAllDrivers')
            ->name('bidding.decline-all-drivers');
        Route::put('bidding/accept-driver/{id}', 'BiddingController@acceptDriver')
            ->name('bidding.accept-driver');
        Route::put('bidding/update-fee/{driver_id}', 'BiddingController@updateFee')
            ->name('bidding.update-fee');
    });

Route::namespace('ETC')
    ->group(function () {
        Route::group(['middleware' => ['api', 'jwt.auth', 'scopes']], function () {
            Route::resource('etcs', 'ETCController')
                ->except([
                    'create',
                    'edit',
                ])
                ->parameters([
                    'etcs' => 'id'
                ]);
        });
        Route::get('etc-bid/{hash}', 'ETCController@showBid')->name('etcs.bid');
        Route::put('etc-bid/{driver}', 'ETCController@updateBid')->name('etcs.updatebid');
    });

Route::namespace('Report')
    ->middleware(['api', 'jwt.auth'])
    ->group(function () {
        Route::get('facility-reports', 'FacilityReportsController@index')->name('facility-reports.index');
        Route::get('etc-reports', 'EtcReportsController@index')->name('etc-reports.index');
        Route::get('facility-reports/{id}', 'FacilityReportsController@show')->name('facility-reports.show');
        Route::get('etc-reports/{id}', 'EtcReportsController@show')->name('etc-reports.show');
        Route::get('facility-reports/{id}/{date}', 'FacilityReportsController@dailyView')
            ->where(['date' => '^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$'])
            ->name('facility-reports.daily-view');
        Route::get('etc-reports/{id}/{date}', 'EtcReportsController@dailyView')
            ->where(['date' => '^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$'])
            ->name('etc-reports.daily-view');
    });
