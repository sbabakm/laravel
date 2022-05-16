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

Route::resource('comments' , CommentController::class )->only(['index','update','destroy']);

Route::get('comments/unapproved',[App\Http\Controllers\Admin\CommentController::class, 'unapprovedComments']);




