<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return view('admin.index');
});

//Route::get('/users', function() {
//    return view('admin.users.all');
//});

Route::resource('users' , UserController::class);

Route::resource('permissions', PermissionController::class);

Route::resource('roles', RoleController::class);

Route::resource('products', ProductController::class)->except('show');

Route::post('/attribute/values', [App\Http\Controllers\Admin\AttributeController::class, 'getValues'] );

Route::resource('comments' , CommentController::class )->only(['index','update','destroy']);

Route::get('comments/unapproved',[App\Http\Controllers\Admin\CommentController::class, 'unapprovedComments']);

Route::resource('categories',CategoryController::class);

Route::resource('/orders',OrderController::class);

Route::get('/order/{order}/payments', [App\Http\Controllers\Admin\OrderController::class, 'viewPayments'])->name('order.payments');

Route::get('/order/{order}/details', [App\Http\Controllers\Admin\OrderController::class, 'orderDetails'])->name('order.details');

Route::post('/productValuesBaseCategoryID', [App\Http\Controllers\Admin\ProductController::class, 'productValuesBaseCategoryID'] );

Route::resource('product.gallery' , ProductGalleryController::class);




