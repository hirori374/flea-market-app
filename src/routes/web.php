<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PurchaseController;
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

//商品一覧・商品詳細
Route::get('/', [ItemController::class,'index'])->name('index');
Route::get('/item/{itemId}', [ItemController::class,'detail'])->name('items.detail');

Route::middleware(['auth', 'verified'])->group(function () {
    //お気に入り登録・解除・コメント
    Route::get('/item/{itemId}/favorite',[ItemController::class,'favorite'])->name('item.favorite');
    Route::get('/item/{itemId}/favorite/delete',[ItemController::class,'favoriteDestroy'])->name('item.favorite.destroy');
    Route::post('/comment/{itemId}', [ItemController::class,'comment'])->name('comment');

    //商品購入・購入情報確認・決済
    Route::get('/purchase/{itemId}', [PurchaseController::class,'purchase'])->name('purchase');
    Route::get('/purchase/payMethod/{itemId}', [PurchaseController::class,'payMethod'])->name('payMethod');
    Route::get('/purchase/address/{itemId}', [PurchaseController::class,'address'])->name('address');
    Route::post('/purchase/address/{itemId}', [PurchaseController::class,'changeAddress'])->name('purchase.address.change');
    Route::post('/purchase/{itemId}', [PurchaseController::class,'checkout'])->name('checkout');
    Route::get('/payment/success/{purchase}', [PurchaseController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancel/{purchase}', [PurchaseController::class, 'cancel'])->name('payment.cancel');
    Route::post('/session', [PurchaseController::class, 'session'])->name('session');

    //商品出品
    Route::get('/sell', [UserController::class,'sell'])->name('sell');
    Route::post('/sell', [UserController::class,'store'])->name('store');

    //マイページ・プロフィール編集
    Route::get('/mypage', [UserController::class,'mypage']);
    Route::get('/mypage/profile', [UserController::class,'profile'])->name('profile');
    Route::patch('/mypage/profile/update', [UserController::class,'update'])->name('profile.update');
});