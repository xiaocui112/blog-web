<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return redirect('topics');
});
//auth 路由
Auth::routes([
    'verify' => true
]);
//用户操作路由
Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);
//博客路由
Route::resource('topics', 'TopicController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::get('topics/{topic}/{slug?}', 'TopicController@show')->name('topics.show');
//话题路由
Route::resource('categories', 'CategoriesController', ['only' => ['show']]);
//上传图片
Route::post('upload_image', 'TopicController@uploadImage')->name('topics.upload_images');
//评论回复
Route::resource('replies', 'RepliesController', ['only' => ['store', 'destroy']]);
//通知路由
Route::resource('notifications', 'NotificationsController', ['only' => ['index']]);
