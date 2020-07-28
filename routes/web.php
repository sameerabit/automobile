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
    Route::get('employees-json', 'EmployeeController@allJson');


    Route::resource('products', 'ProductController');
    Route::get('products-search', 'ProductController@searchByName');
    Route::get('suppliers-search', 'SupplierController@searchByName');

    Route::resource('units', 'UnitController');

    Route::resource('supplier-bill', 'SupplierBill\SupplierBillController');
    Route::get('supplier-bill-details/{bill_id}', 'SupplierBill\SupplierBillController@getSupplierBillDetails');


    Route::resource('supplier-returns', 'SupplierReturn\SupplierReturnController');
    Route::get('supplier-return-details/{return_id}', 'SupplierReturn\SupplierReturnController@getSupplierReturnDetails');


    Route::get('job-cards/create','JobCard\JobCardController@create')->name('job-cards.create');
    Route::post('job-cards','JobCard\JobCardController@store')->name('job-cards.store');
    Route::post('job-card-details','JobCard\JobCardDetailController@store')->name('job-cards-details.store');

    Route::get('job-cards/{job_card_id}/details','JobCard\JobCardDetailController@getJobDetailsFromJobCardId')->name('job_cards.job_card_details');
    Route::delete('job-card-detail/{job_card_detail}','JobCard\JobCardDetailController@destroy')->name('job_card_detail.delete');
    Route::put('job-card-detail/{job_card_detail}','JobCard\JobCardDetailController@update')->name('job_card_detail.update');

