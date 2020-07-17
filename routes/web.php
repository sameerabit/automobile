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
    Route::resource('vehicles', 'VehicleController');
    Route::resource('employees', 'EmployeeController');


    Route::resource('products', 'ProductController');
    Route::get('products-search', 'ProductController@searchByName');
    Route::get('suppliers-search', 'SupplierController@searchByName');

    Route::resource('units', 'UnitController');

    Route::resource('supplier-bill', 'SupplierBill\SupplierBillController'); 
    Route::get('supplier-bill-details/{bill_id}', 'SupplierBill\SupplierBillController@getSupplierBillDetails');
    
    
    Route::resource('supplier-returns', 'SupplierReturn\SupplierReturnController'); 
    Route::get('supplier-return-details/{return_id}', 'SupplierReturn\SupplierReturnController@getSupplierReturnDetails'); 


    Route::get('job-cards/create','JobCard\JobCardController@create')->name('job-cards.create');

