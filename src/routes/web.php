<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\UserController;

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

Route::get('/', [ItemController::class, 'index']);
Route::get('/item/{item_id}', [ItemController::class, 'show']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/purchase/address/{item_id}', [AddressController::class, 'edit']);
    Route::post('/purchase/address/{item_id}', [AddressController::class, 'update']);
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'create']);
    Route::post('/purchase/{item_id}', [PurchaseController::class, 'store']);
    Route::get('/sell', [ItemController::class, 'create']);
    Route::post('/sell', [ItemController::class, 'store']);
    Route::get('/mypage', [UserController::class, 'index']);
    Route::get('/mypage/profile', [UserController::class, 'edit']);
    Route::put('/mypage/profile', [UserController::class, 'update']);
    Route::post('/item/{item_id}/like', [ItemController::class, 'like']);
    Route::delete('/item/{item_id}/like', [ItemController::class, 'unlike']);
    Route::post('/item/{item_id}/comment', [ItemController::class, 'comment']);
});
