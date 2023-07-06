<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\BillDetailController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\StoreBranchController;
use App\Http\Controllers\StoreController;
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

Route::middleware('guest')->group(function () {
    // Login
    Route::post('login', [AuthController::class, 'login']);

    // Forgot password
    Route::post('password/forgot', [PasswordController::class, 'forgotPassword']);
    Route::post('password/reset', [PasswordController::class, 'resetPassword']);
});

Route::middleware('auth:api')->group(function () {
    // User information
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('profile', [ProfileController::class, 'getProfile']);
    Route::put('profile', [ProfileController::class, 'updateProfile']);
    Route::post('password/change', [PasswordController::class, 'changePassword']);

    // Store
    Route::resource('stores', StoreController::class);

    // Store Branch
    Route::get('store_branches/{storeId}', [StoreBranchController::class, 'index']);
    Route::get('store_branches/{id}', [StoreBranchController::class, 'show']);
    Route::post('store_branches', [StoreBranchController::class, 'store']);
    Route::put('store_branches/{id}', [StoreBranchController::class, 'update']);
    Route::delete('store_branches/{id}', [StoreBranchController::class, 'destroy']);

    // Items
    Route::get('items/{storeId}', [ItemController::class, 'index']);
    Route::get('items/{id}', [ItemController::class, 'show']);
    Route::post('items', [ItemController::class, 'store']);
    Route::put('items/{id}', [ItemController::class, 'update']);
    Route::delete('items/{id}', [ItemController::class, 'destroy']);

    // Bill
    Route::resource('bills', BillController::class);
    Route::resource('bill_details', BillDetailController::class);

});
