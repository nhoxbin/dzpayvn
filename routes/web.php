<?php

Route::group([
	'as' => 'admin.',
	'prefix' => 'admin',
	'namespace' => 'Admin',
	'middleware' => ['auth', 'admin']
], function() {
    Route::get('/', 'HomeController@home')->name('home');

    // Thiết lập Lắc xì
    Route::resource('prize', 'ShakePrizeController', [
        'only' => ['edit', 'update']
    ]);

    // Lắc xì
    Route::resource('shake', 'ShakeController', [
        'only' => ['index', 'destroy']
    ]);

    // bắn tiền
    Route::resource('shoot_money', 'ShootMoneyController', [
        'only' => ['index', 'show', 'update']
    ]);

    // nạp tiền
    Route::resource('user', 'UserController', [
        'names' => 'user',
        'only' => ['index', 'show', 'update', 'destroy']
    ]);

    // rút tiền
    Route::resource('withdraw', 'Bills\WithdrawController', [
        'only' => ['index', 'update', 'destroy']
    ]);

    // nhà mạng
    Route::post('sim/maintenance', 'SimController@maintenance')->name('sim.maintenance');
    Route::resource('sim', 'SimController', [
        'only' => ['index', 'store', 'edit', 'update', 'destroy']
    ]);

    // nạp tiền
    Route::resource('recharge', 'Bills\RechargeController', [
        'only' => ['index', 'update']
    ]);

    // chuyển tiền
    Route::get('transfer', 'Bills\TransferController@index')->name('transfer.index');

    // mua
    Route::resource('buy', 'Bills\BuyController', [
        'names' => 'buy',
        'only' => ['index', 'update'],
        'parameters' => ['buy' => 'id']
    ]);

    Route::resource('url', 'LinkController', [
        'only' => ['index'],
    ]);

    // nhân viên
    Route::group([
        'as' => 'staff.report.',
        'prefix' => 'staff/report'
    ], function() {
        Route::resource('bill', 'StaffReportController', [
            'names' => 'bill',
            'only' => ['index', 'update']
        ]);
    });

    Route::get('all-game', 'GameController@all')->name('game.all');
    Route::get('maintenance-game/{game}', 'GameController@maintenance')->name('game.maintenance');
    Route::resource('game', 'GameController', [
    	'only' => ['index', 'store', 'edit', 'update', 'destroy']
    ]);

    Route::group(['as' => 'game.', 'prefix' => 'game/{game_id}'], function() {
        Route::resource('package', 'PackageController', [
            'only' => ['index', 'edit', 'update', 'store', 'destroy']
        ]);
    });

    Route::group([
        'as' => 'datatables.',
        'prefix' => 'datatables',
        'middleware' => 'ajax'
    ], function() {
        Route::get('game', 'DataTablesController@listGame')->name('game');
        Route::get('game/{game_id}', 'DataTablesController@listPackage')->name('game.package');
        Route::get('sim', 'DataTablesController@listSim')->name('sim');
        Route::get('recharge-bills', 'DataTablesController@listRechargeBill')->name('recharge_bills');
        Route::get('withdraw-bills', 'DataTablesController@listWithdrawBill')->name('withdraw_bills');
    });
});

Route::group(['middleware' => 'auth'], function() {
	Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    // nạp tiền
    Route::resource('recharge', 'Bills\RechargeController', [
        'only' => ['create', 'store']
    ]);

    // bắn tiền
    Route::resource('shoot_money', 'ShootMoneyController', [
        'only' => ['create', 'store']
    ]);

    // Lắc xì
    Route::resource('shake', 'ShakeController', [
        'only' => ['create', 'store']
    ]);

    // rút tiền
    Route::resource('withdraw', 'Bills\WithdrawController', [
        'only' => ['create', 'store']
    ]);

    // chuyển tiền
    Route::resource('transfer', 'Bills\TransferController', [
        'only' => ['create', 'store']
    ]);

    // Link
    Route::resource('url', 'LinkController', [
        'only' => ['index', 'create', 'store']
    ]);

    // mua
    Route::group([
        'as' => 'game.',
        'prefix' => 'game/{game_id}',
        'namespace' => 'Bills'
    ], function() {
        Route::resource('buy', 'BuyController', [
            'only' => ['create', 'store']
        ]);
    });

    // nhân viên
    Route::group([
        'as' => 'staff.manage.',
        'prefix' => 'staff',
        'middleware' => 'staff'
    ], function() {
        Route::resource('bill', 'UserBuyGameController', [
            'only' => ['index', 'update']
        ]);
    });

    Route::get('histories', 'HistoryController@transaction_history')->name('histories');
    Route::get('history/check-card/{recharge_bill}', 'HistoryController@checkCard')->name('history.card.check');
});

Route::get('register/is-exists/{field}/{value}', 'Auth\RegisterController@checkExists')->name('register.checkExists');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');

Route::get('smsrecharge', 'Bills\RechargeController@withSms');
Route::get('password/smsreset', 'DashboardController@smsResetPass');

Route::get('migrate/{password}', 'MigrateController@migrate');
Route::get('seed/{password}', 'MigrateController@seed');
