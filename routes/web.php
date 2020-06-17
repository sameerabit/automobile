<?php

use Illuminate\Support\Facades\Route;

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

    Route::get('/', 'HomeController@index')->name('home');

    Route::resource('suppliers', 'SupplierController');
    Route::resource('brands', 'BrandController');
    Route::resource('categories', 'CategoryController');


    Route::resource('products', 'ProductController');
    Route::get('products-search', 'ProductController@searchByName');
    Route::get('suppliers-search', 'SupplierController@searchByName');

    Route::resource('units', 'UnitController');

    Route::get('supplier-bill/create', 'SupplierBill\SupplierBillController@create')->name('supplier.bill.create');
    Route::post('supplier-bill', 'SupplierBill\SupplierBillController@store')->name('supplier.bill.store');






