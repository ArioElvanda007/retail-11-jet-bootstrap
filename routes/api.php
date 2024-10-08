<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/** origin 
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
*/

Route::prefix('global')->group(function () {
    Route::get('select-supplier/{supplier}', [App\Http\Controllers\API\GlobalAPIController::class, 'selectSupplier']);
    Route::get('select-customer/{customer}', [App\Http\Controllers\API\GlobalAPIController::class, 'selectCustomer']);
    Route::get('select-product-id/{product}', [App\Http\Controllers\API\GlobalAPIController::class, 'selectProductID']);
    Route::get('select-product-code/{product}', [App\Http\Controllers\API\GlobalAPIController::class, 'selectProductCode']);
});

Route::prefix('report')->group(function () {
    Route::get('stock/{fromDate}/{type}', [App\Http\Controllers\API\ReportAPIController::class, 'stock']);
    Route::get('buying/{fromDate}/{type}', [App\Http\Controllers\API\ReportAPIController::class, 'buying']);
    Route::get('selling/{fromDate}/{type}', [App\Http\Controllers\API\ReportAPIController::class, 'selling']);
    Route::get('cashflows/{fromDate}/{type}', [App\Http\Controllers\API\ReportAPIController::class, 'cashflows']);
    Route::get('accounting/{fromDate}/{toDate}', [App\Http\Controllers\API\ReportAPIController::class, 'accounting']);
});

Route::prefix('content')->group(function () {
    Route::get('dashboard', [App\Http\Controllers\API\ContentAPIController::class, 'dashboard']);
});