<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PurchaseController;
use App\Http\Controllers\Api\SupplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// category routes
Route::get('/category/list', [CategoryController::class, 'getCategoryList']);
Route::post('/category/store', [CategoryController::class, 'storeCategory']);

// product routes
Route::get('/product/list', [ProductController::class, 'getProductList']);
Route::post('/product/store', [ProductController::class, 'storeProduct']);
Route::put('/product/update/{id}', [ProductController::class, 'updateProduct']);
Route::delete('/product/delete/{id}', [ProductController::class, 'deleteProduct']);

// supplier routes
Route::get('/supplier/list', [SupplierController::class, 'getSupplierList']);
Route::post('/supplier/store', [SupplierController::class, 'storeSupplier']);
Route::put('/supplier/update/{id}', [SupplierController::class, 'updateSupplier']);
Route::delete('/supplier/delete/{id}', [SupplierController::class, 'deleteSupplier']);

// supplier routes
Route::get('/purchase-orders', [PurchaseController::class, 'getPurchaseOrders']);
Route::post('/purchase-order/store', [PurchaseController::class, 'storePurchaseOrder']);
