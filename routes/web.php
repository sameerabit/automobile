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
    Route::resource('insurance_companies', 'InsuranceCompanyController');

    Route::get('employees-json', 'EmployeeController@allJson');

    Route::resource('products', 'ProductController');
    Route::get('products-json', 'ProductController@allJson');
    Route::get('products-search', 'ProductController@searchByName');
    Route::get('products-search-by-bill-id/{bill_id}', 'ProductController@searchByBillId');
    Route::get('suppliers-search', 'SupplierController@searchByName');

    Route::resource('units', 'UnitController');

    Route::resource('supplier-bill', 'SupplierBill\SupplierBillController')->except([
        'update',
    ]);
    Route::post('supplier-bill/{supplier_bill}', 'SupplierBill\SupplierBillController@update')->name('supplier-bill.update');
    Route::get('supplier-bill-details/{bill_id}', 'SupplierBill\SupplierBillController@getSupplierBillDetails');

    Route::resource('supplier-returns', 'SupplierReturn\SupplierReturnController');
    Route::get('supplier-returns/{bill_id}/make', 'SupplierReturn\SupplierReturnController@createReturn')->name('bill.create_return');
    Route::get('supplier-return-details/{return_id}', 'SupplierReturn\SupplierReturnController@getSupplierReturnDetails');

    Route::get('job-cards/create', 'JobCard\JobCardController@create')->name('job-cards.create');
    Route::post('job-cards', 'JobCard\JobCardController@store')->name('job-cards.store');
    Route::post('job-card-details', 'JobCard\JobCardDetailController@store')->name('job-cards-details.store');

    Route::get('job-cards/{job_card_id}/details', 'JobCard\JobCardDetailController@getJobDetailsFromJobCardId')->name('job_cards.job_card_details');
    Route::delete('job-card-detail/{job_card_detail}', 'JobCard\JobCardDetailController@destroy')->name('job_card_detail.delete');
    Route::put('job-card-detail/{job_card_detail}', 'JobCard\JobCardDetailController@update')->name('job_card_detail.update');

    Route::get('job-cards/{job_card}/edit', 'JobCard\JobCardController@edit')->name('job_cards.edit');
    Route::get('job-cards', 'JobCard\JobCardController@index')->name('job_cards.index');
    Route::get('job-cards/{job_card}/bill', 'JobCard\JobCardController@createBill')->name('job_cards.bill');

    Route::delete('job-cards/{job_card}', 'JobCard\JobCardController@destroy')->name('job_cards.destroy');
    Route::put('job-card-detail/{job_card_detail}/update-time', 'JobCard\JobCardDetailController@updateTime')->name('job_card_detail.update');
    Route::get('job-card-detail/{job_card_detail}/json', 'JobCard\JobCardDetailController@findJson')->name('job_card_detail.get-json');

    Route::get('job-sales/{job_sale}', 'JobSale\JobSaleController@getJobSale')->name('job_sales.items');
    Route::get('job-sales', 'JobSale\JobSaleController@index')->name('job_sales.index');
    Route::post('job-sales', 'JobSale\JobSaleController@store')->name('job_sales.store');
    Route::put('job-sales/{job_sale}', 'JobSale\JobSaleController@update')->name('job_sales.update');
    Route::delete('job-sales/{job_sale}', 'JobSale\JobSaleController@delete')->name('job_sales.delete');

    Route::get('bookings', 'Booking\BookingController@index')->name('booking.index');
    Route::post('bookings', 'Booking\BookingController@store')->name('booking.store');
    Route::get('bookings-json', 'Booking\BookingController@getBookingJson')->name('bookings.json');
    Route::get('bookings-json/{id}', 'Booking\BookingController@getSingleBooking')->name('bookings.json');
    Route::delete('bookings-json/{id}', 'Booking\BookingController@deleteBooking')->name('bookings.delete');

    Route::get('insurance-claims', 'InsuranceClaim\InsuranceClaimController@index')->name('insurance_claim.index');
    Route::get('insurance-claims/create', 'InsuranceClaim\InsuranceClaimController@create')->name('insurance_claim.create');
    Route::post('insurance-claims', 'InsuranceClaim\InsuranceClaimController@store')->name('insurance_claim.store');
    Route::get('insurance-claims/{insurance_claim}/edit', 'InsuranceClaim\InsuranceClaimController@edit')->name('insurance_claim.edit');
    Route::delete('insurance-claims/{insurance_claim}', 'InsuranceClaim\InsuranceClaimController@destroy')->name('insurance_claim.destroy');

    Route::get('insurance-claim-details/{insurance_claim_id}/details', 'InsuranceClaim\InsuranceClaimDetailsController@getInsuranceClaimDetailsFromInsuranceClaimId')->name('insurance_claim.insurance_claim_details');
    Route::delete('insurance-claim-details/{insurance_claim_detail}', 'InsuranceClaim\InsuranceClaimDetailsController@destroy')->name('insurance_claim_detail.delete');
    Route::put('insurance-claim-details/{insurance_claim_detail}', 'InsuranceClaim\InsuranceClaimDetailsController@update')->name('insurance_claim_detail.update');
    Route::post('insurance-claim-details', 'InsuranceClaim\InsuranceClaimDetailsController@store')->name('jinsurance_claim_detail.store');

    Route::resource('roles', 'RoleController');
    Route::resource('permissions', 'PermissionController');


    Route::get('products-report', 'Report\ReportController@products')->name('report.products');


    Route::get('users', 'Auth\UserController@index')->name('users.index');
    Route::get('users/{user}reset','Auth\ResetPasswordController@resetPasswordForUser')->name('users.reset.password');
