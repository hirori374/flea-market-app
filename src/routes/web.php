<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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

//メール認証誘導画面へ
Route::get('/email/verify', function () {
    return view('auth.verify_email');
})->middleware('auth')->name('verification.notice');
//メール認証ボタン
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/mypage/profile');
})->middleware(['auth', 'signed'])->name('verification.verify');
//メール再送ボタン
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back();
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::get('/', [ItemController::class,'index'])->name('index');
Route::get('/item/{itemId}', [ItemController::class,'detail'])->name('items.detail');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/item/{itemId}/favorite',[ItemController::class,'favorite'])->name('item.favorite');
    Route::get('/item/{itemId}/favorite/delete',[ItemController::class,'favoriteDestroy'])->name('item.favorite.destroy');
    Route::get('/comment/{itemId}', [ItemController::class,'comment'])->name('comment');

    Route::get('/purchase/{itemId}', [ItemController::class,'purchase'])->name('purchase');
    Route::get('/purchase/payMethod/{itemId}', [ItemController::class,'payMethod'])->name('payMethod');
    Route::get('/purchase/address/{itemId}', [ItemController::class,'address'])->name('address');
    Route::post('/purchase/{itemId}/address', [ItemController::class,'updateAddress'])->name('purchase.address.update');
    Route::post('/purchase/{itemId}', [ItemController::class,'checkout'])->name('checkout');
    Route::get('/payment/success/{purchase}', [ItemController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancel/{purchase}', [ItemController::class, 'cancel'])->name('payment.cancel');
    Route::post('/session', [ItemController::class, 'session'])->name('session');

    Route::get('/sell', [UserController::class,'sell'])->name('sell');
    Route::post('/sell', [UserController::class,'store'])->name('store');

    Route::get('/mypage', [UserController::class,'mypage']);
    Route::get('/mypage/profile', [UserController::class,'profile'])->name('profile');
    Route::patch('/mypage/profile/update', [UserController::class,'update'])->name('profile.update');
});