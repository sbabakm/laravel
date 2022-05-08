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

Route::get('/secret', function() {
    return 'secret';
})->middleware(['auth','password.confirm']);

Route::get('/', function () {
//     alert()->success('salam babak','Message')->persistent('OK');
//    auth()->user()->activeCode()->create([
//        'code' => 111111,
//        'expired_at' => now()->addMinutes(10)
//    ]);

//    $user = \App\Models\User::find(3);
//    if(Gate::allows('edit-user' , $user)) {
//       dd('yes');
//    }
//    dd('no');

//    $user = \App\Models\User::find(1);
//    return $user->permissions()->get();

//    auth()->loginUsingId(1);
    auth()->logout();

//    dd(auth()->user()->activeCode);

    $product = \App\Models\Product::find(2);

//    auth()->user()->comments()->create([
//        'comment' => 'first comment',
//        'commentable_id' => $product->id,
//        //'commentable_type' => 'App\Product',
//        'commentable_type' => get_class($product),
//    ]);

//    $product->comments()->create([
//        'user_id' => auth()->user()->id,
//        'comment' => 'second comment',
//    ]);
//
//    dd($product->comments()->get());

//    $comment = \App\Models\Comment::find(2);
//    dd($comment->commentable);


   if(Gate::allows('edit-user')) {
       return view('welcome');
   }
    return 'no';

    //return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/auth/google', [App\Http\Controllers\Auth\GoogleAuthController::class, 'redirect'])->name('auth.google');

Route::get('/auth/google/callback', [App\Http\Controllers\Auth\GoogleAuthController::class, 'callback']);

Route::get('auth/token',[App\Http\Controllers\Auth\AuthTokenController::class, 'getToken'])->name('2fa.token');

Route::post('auth/token',[App\Http\Controllers\Auth\AuthTokenController::class, 'postToken']);

Route::middleware('auth')->group(function (){

    Route::get('profile', [App\Http\Controllers\Profile\ProfileController::class, 'index'])->name('profile');

    Route::get('profile/twofactor', [App\Http\Controllers\Profile\ProfileController::class, 'manageTwoFactor'])->name('profile.2fa.manage');

    Route::post('profile/twofactor', [App\Http\Controllers\Profile\ProfileController::class, 'postManageTwoFactor']);

    Route::get('profile/twofactor/phone', [App\Http\Controllers\Profile\ProfileController::class , 'getPhoneVerify'])->name('profile.2fa.phone');

    Route::post('profile/twofactor/phone', [App\Http\Controllers\Profile\ProfileController::class , 'postPhoneVerify']);
});

Route::get('/products', [App\Http\Controllers\ProductController::class, 'index']);
Route::get('/product/{product}', [App\Http\Controllers\ProductController::class, 'single']);
Route::get('/productV2/{product}', [App\Http\Controllers\ProductController::class, 'singleV2']);
Route::post('comments' , [App\Http\Controllers\HomeController::class, 'comment'])->name('send.comment');

//test
Route::get('/babak/{x}/{z}',function ($y, $w) {
    return ' salam ' . $y . ' ' . $w;
})->name('bbk');

