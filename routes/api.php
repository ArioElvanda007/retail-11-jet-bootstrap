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
    Route::get('select-product-id/{product}', [App\Http\Controllers\API\GlobalAPIController::class, 'selectProductID']);
    Route::get('select-product-code/{product}', [App\Http\Controllers\API\GlobalAPIController::class, 'selectProductCode']);
});