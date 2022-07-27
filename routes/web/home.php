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

    auth()->loginUsingId(1);
//    auth()->logout();

//    dd(auth()->user()->activeCode);

//    $product = \App\Models\Product::find(2);

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

//    dd(Carbon\Carbon::today());
//    $current = Carbon\Carbon::now();
//    dd($current->addDays(2));
//    dd($current->toDateString());
//    dd($current->toFormattedDateString());

    //dd(\Morilog\Jalali\Jalalian::now());
    //dd(jdate());
    //dd(\Morilog\Jalali\Jalalian::now()->format('%A, %d %B %y'));
    //dd(jdate()->format('%A, %d %B %y'));

//    dd(\App\Models\User::all()->pluck('id')->toArray());

//    dd(\App\Models\Category::find(3)->child->count());

//    collect([1,2,3,4])->each(function ($item){
//        if ($item === 2) {
//            return true;
//        }
//        echo $item;
//    });

//    collect([1,2,3,4])->each(function ($item){
//        if ($item === 2) {
//            return false;
//        }
//        echo $item;
//    });

//    $temp = new App\Helpers\Cart\CartService();
//    dd($temp->get(33));

//    dd(Cart::get(55));

//    dd(session()->get('cart'));

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

    Route::get('profile/orders', [App\Http\Controllers\Profile\OrderController::class , 'index'])->name('profile.orders');
    Route::get('profile/orders/{order}', [App\Http\Controllers\Profile\OrderController::class , 'showDetails'])->name('profile.orders.details');
    Route::get('profile/orders/{order}/payment', [App\Http\Controllers\Profile\OrderController::class , 'payment'])->name('profile.orders.payment');

});

Route::get('/products', [App\Http\Controllers\ProductController::class, 'index']);
Route::get('/product/{product}', [App\Http\Controllers\ProductController::class, 'single']);
Route::get('/productV2/{product}', [App\Http\Controllers\ProductController::class, 'singleV2']);
Route::post('comments' , [App\Http\Controllers\HomeController::class, 'comment'])->name('send.comment');

Route::post('/cart/add/{product}', [App\Http\Controllers\CartController::class, 'addProductToCart'])->name('cart.add');
Route::get('/show/cart', [App\Http\Controllers\CartController::class, 'showCart']);
Route::get('/show/cart2', [App\Http\Controllers\CartController::class, 'showCart2']);
Route::patch('/cart/quantity/change', [App\Http\Controllers\CartController::class, 'quantityChange'] )->name('cart.quantity.change');
Route::delete('/cart/delete/{id}', [App\Http\Controllers\CartController::class, 'deleteItemFromCart'] )->name('cart.delete.item');

Route::post('payment' , [App\Http\Controllers\PaymentController::class, 'payment'])->name('cart.payment');
Route::get('payment/callback' , [App\Http\Controllers\PaymentController::class, 'callback'])->name('payment.callback');

//test
Route::get('/babak/{x}/{z}',function ($y, $w) {
    return ' salam ' . $y . ' ' . $w;
})->name('bbk');
Route::get('show/session',function (){
   //return session()->get('cart');
    //dd(session()->get('cart'));

    //dd(Cart::all());
//    session()->flush();
    dd(session()->all());
});
Route::get('show/cookie',function (){
    //dd(\App\Helpers\Cart\Cart::instance('roocket')->all());
    //dd(request()->cookie('roocket'));
    //dd(json_decode(request()->cookie('roocket')));
    //dd(json_decode(request()->cookie('roocket') , true));
    dd(request()->cookie());
});

