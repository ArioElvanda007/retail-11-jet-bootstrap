<?php

use Illuminate\Support\Facades\Route;

/** origin
    Route::get('/', function () {
        return view('welcome');
    });

    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ])->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
    }); 
*/

use App\Http\Controllers\DashboardController;

use App\Http\Controllers\Stock\ProductController;
use App\Http\Controllers\Stock\StockController;

use App\Http\Controllers\Buying\SupplierController;
use App\Http\Controllers\Buying\BuyingController;

use App\Http\Controllers\Selling\CustomerController;
use App\Http\Controllers\Selling\SellingController;

use App\Http\Controllers\Accounting\BankController;
use App\Http\Controllers\Accounting\CashFlowController;

use App\Http\Controllers\Report\Stock\ReportStockController;
use App\Http\Controllers\Report\Buying\ReportBuyingController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\BusinessController;

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware(['can:manage dashboard']);

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['can:manage dashboard']);


    Route::prefix('stock')->name('stock.')->middleware(['can:manage stock'])->group(function () {
        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');
            Route::get('/create', [ProductController::class, 'create'])->name('create');
            Route::post('/', [ProductController::class, 'store'])->name('store');
            Route::get('/edit/{product}', [ProductController::class, 'edit'])->name('edit');
            Route::post('{product}', [ProductController::class, 'update'])->name('update');
            Route::get('{product}', [ProductController::class, 'destroy'])->name('destroy');
        });     

        Route::prefix('stocks')->name('stocks.')->group(function () {
            Route::get('/', [StockController::class, 'index'])->name('index');
            Route::get('/create', [StockController::class, 'create'])->name('create');
            Route::post('/', [StockController::class, 'store'])->name('store');
            Route::get('/edit/{stock}', [StockController::class, 'edit'])->name('edit');
            Route::post('{stock}', [StockController::class, 'update'])->name('update');
            Route::get('{stock}', [StockController::class, 'destroy'])->name('destroy');
        });     
    });

    Route::prefix('buying')->name('buying.')->middleware(['can:manage buying'])->group(function () {
        Route::prefix('suppliers')->name('suppliers.')->group(function () {
            Route::get('/', [SupplierController::class, 'index'])->name('index');
            Route::get('/create', [SupplierController::class, 'create'])->name('create');
            Route::post('/', [SupplierController::class, 'store'])->name('store');
            Route::get('/edit/{supplier}', [SupplierController::class, 'edit'])->name('edit');
            Route::post('{supplier}', [SupplierController::class, 'update'])->name('update');
            Route::get('{supplier}', [SupplierController::class, 'destroy'])->name('destroy');
        });     

        Route::prefix('buying')->name('buying.')->group(function () {
            Route::get('/', [BuyingController::class, 'index'])->name('index');
            Route::get('/create', [BuyingController::class, 'create'])->name('create');
            Route::post('/', [BuyingController::class, 'store'])->name('store');
            Route::get('/edit/{buying}', [BuyingController::class, 'edit'])->name('edit');
            Route::post('{buying}', [BuyingController::class, 'update'])->name('update');
            Route::get('{buying}', [BuyingController::class, 'destroy'])->name('destroy');
            Route::get('/print/{buying}', [BuyingController::class, 'print'])->name('print');
        });     
    });

    Route::prefix('selling')->name('selling.')->middleware(['can:manage selling'])->group(function () {
        Route::prefix('customers')->name('customers.')->group(function () {
            Route::get('/', [CustomerController::class, 'index'])->name('index');
            Route::get('/create', [CustomerController::class, 'create'])->name('create');
            Route::post('/', [CustomerController::class, 'store'])->name('store');
            Route::get('/edit/{customer}', [CustomerController::class, 'edit'])->name('edit');
            Route::post('{customer}', [CustomerController::class, 'update'])->name('update');
            Route::get('{customer}', [CustomerController::class, 'destroy'])->name('destroy');
        });     

        Route::prefix('selling')->name('selling.')->group(function () {
            Route::get('/', [SellingController::class, 'index'])->name('index');
            Route::get('/create', [SellingController::class, 'create'])->name('create');
            Route::post('/', [SellingController::class, 'store'])->name('store');
            Route::get('/edit/{selling}', [SellingController::class, 'edit'])->name('edit');
            Route::post('{selling}', [SellingController::class, 'update'])->name('update');
            Route::get('{selling}', [SellingController::class, 'destroy'])->name('destroy');
            Route::get('/print/{selling}', [SellingController::class, 'print'])->name('print');
        });     
    });

    Route::prefix('accounting')->name('accounting.')->middleware(['can:manage accounting'])->group(function () {
        Route::prefix('banks')->name('banks.')->group(function () {
            Route::get('/', [BankController::class, 'index'])->name('index');
            Route::get('/create', [BankController::class, 'create'])->name('create');
            Route::post('/', [BankController::class, 'store'])->name('store');
            Route::get('/edit/{bank}', [BankController::class, 'edit'])->name('edit');
            Route::post('{bank}', [BankController::class, 'update'])->name('update');
            Route::get('{bank}', [BankController::class, 'destroy'])->name('destroy');
        });     

        Route::prefix('cashflows')->name('cashflows.')->group(function () {
            Route::get('/', [CashFlowController::class, 'index'])->name('index');
            Route::get('/create', [CashFlowController::class, 'create'])->name('create');
            Route::post('/', [CashFlowController::class, 'store'])->name('store');
            Route::get('/edit/{cashflow}', [CashFlowController::class, 'edit'])->name('edit');
            Route::post('{cashflow}', [CashFlowController::class, 'update'])->name('update');
            Route::get('{cashflow}', [CashFlowController::class, 'destroy'])->name('destroy');
        });     
    });






    Route::prefix('report')->name('report.')->middleware(['can:manage report'])->group(function () {
        Route::prefix('stocks')->name('stocks.')->group(function () {
            Route::get('/', [ReportStockController::class, 'index'])->name('index');
        }); 

        Route::prefix('buying')->name('buying.')->group(function () {
            Route::get('/', [ReportBuyingController::class, 'index'])->name('index');
        }); 
    });





    
    Route::prefix('admin')->name('admin.')->middleware(['can:admin'])->group(function () {
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit');
            Route::post('{user}', [UserController::class, 'update'])->name('update');
            Route::get('{user}', [UserController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('roles')->name('roles.')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('index');
            Route::get('/create', [RoleController::class, 'create'])->name('create');
            Route::post('/', [RoleController::class, 'store'])->name('store');
            Route::get('/edit/{role}', [RoleController::class, 'edit'])->name('edit');
            Route::post('{role}', [RoleController::class, 'update'])->name('update');
            Route::get('{role}', [RoleController::class, 'destroy'])->name('destroy');
        });        

        Route::prefix('business')->name('business.')->group(function () {
            Route::get('/', [BusinessController::class, 'index'])->name('index');
            Route::get('/create', [BusinessController::class, 'create'])->name('create');
            Route::post('/', [BusinessController::class, 'store'])->name('store');
            Route::get('/edit/{business}', [BusinessController::class, 'edit'])->name('edit');
            Route::post('{business}', [BusinessController::class, 'update'])->name('update');
        });        
    });
});

