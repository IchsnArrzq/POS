<?php

use Illuminate\Support\Facades\Route;
// Login
Route::group(['middleware' => 'guest'], function () {
    Route::get('/', function () {
        return view('auth.login');
    });
});
Auth::routes();
// Print


// dashboard
Route::prefix('menu')->name('menu.')->middleware('auth')->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    // CashierAccess
    Route::group(['middleware' => 'checkRole:kasir'], function () {
        // Cashier
        Route::prefix('cashier')->name('cashier.')->group(function () {
            Route::get('/', 'CashierController@index')->name('index');
            Route::get('/get/{id}', 'CashierController@get')->name('get');
            Route::post('/purchase', 'CashierController@purchase')->name('purchase');
            Route::post('/cart','CartController@index')->name('cart');
            Route::get('/cart/{id}','CartController@delete')->name('delete');
        });
    });
    // ManagerAccess
    Route::group(['middleware' => 'checkRole:manager'], function () {
        // Cashier
        Route::prefix('manager')->name('manager.')->group(function () {
            Route::geT('/', 'ManagerController@index')->name('index');
            Route::get('/stock', 'ManagerController@stock')->name('stock');
            Route::get('/date', 'ManagerController@date')->name('date');
            Route::get('/print_pdf', 'managerController@print_pdf')->name('print');;
            Route::get("/export_excell", 'managerController@export_excel')->name('export');
            Route::get("/export_goods", 'managerController@export_goods')->name('export_goods');
        });
    });
    // AdminAccess
    Route::group(['middleware' => 'checkRole:admin'], function () {
        // User
        Route::prefix('user')->name('user.')->group(function () {
            Route::get('/user', 'UserController@index')->name('index');
            Route::post('/store', 'UserController@store')->name('store');
            Route::delete('/delete/{id}', 'UserController@destroy')->name('delete');
            Route::get('/search/', 'UserController@search')->name('search');
        });
        // barang
        Route::prefix('goods')->name('goods.')->group(function () {
            Route::get('/goods', 'GoodsController@index')->name('index');
            Route::post('/store', 'GoodsController@store')->name('store');
            Route::delete('/delete/{id}', 'GoodsController@destroy')->name('delete');
            Route::get('/edit/{id}', 'GoodsController@edit')->name('edit');
            Route::put('/update/{id}', 'GoodsController@update')->name('update');
            Route::get('/search/', 'GoodsController@search')->name('search');
        });
        // merek
        Route::prefix('merk')->name('merk.')->group(function () {
            Route::get('/merk', 'MerkController@index')->name('index');
            Route::post('/store', 'MerkController@store')->name('store');
            Route::delete('/delete/{id}', 'MerkController@destroy')->name('delete');
            Route::get('/edit/{id}', 'MerkController@edit')->name('edit');
            Route::put('/update/{id}', 'MerkController@update')->name('update');
            Route::get('/search/', 'MerkController@search')->name('search');
        });
        // distributor
        Route::prefix('distributor')->name('distributor.')->group(function () {
            Route::get('/distributor', 'DistributorController@index')->name('index');
            Route::post('/store', 'DistributorController@store')->name('store');
            Route::delete('/delete/{id}', 'DistributorController@destroy')->name('delete');
            Route::get('/edit/{id}', 'DistributorController@edit')->name('edit');
            Route::put('/update/{id}', 'DistributorController@update')->name('update');
            Route::get('/search/', 'DistributorController@search')->name('search');
        });
    });
});
