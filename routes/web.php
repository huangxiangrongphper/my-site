<?php

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

Route::get('/','QuestionsController@index');

Route::post('/deploy','DeploymentController@deploy');

Route::any('/wechat', 'WeChatController@serve');

Route::get('/image','MaterialController@image');
Route::get('/audio','MaterialController@audio');

Route::get('/about','UsersController@about');

Route::get('/user/register','UsersController@register');
Route::get('/verify/token/{confirm_code}',['as' => 'email.verify','uses' => 'UsersController@confirmEmail']);
Route::post('/user/register','UsersController@store');
Route::get('/user/login','UsersController@login')->name('login');
Route::post('/user/login','UsersController@signin');
Route::get('/user/avatar','UsersController@avatar');
Route::post('/avatar','UsersController@changeAvatar');
Route::post('/crop/api','UsersController@cropAvatar');
Route::post('/post/upload','PostsController@upload');
Route::match(['get','post'],'password/reset','UsersController@reset');

Route::get('discussions/index','PostsController@index');
Route::get('discussions/show/{id}','PostsController@show');
Route::get('discussions/create','PostsController@create');
Route::post('discussions/store','PostsController@store');
Route::match(['get','post'],'discussions/{id}/edit','PostsController@edit');

Route::get('/logout','UsersController@logout');
Route::match(['get','post'],'password/email','UsersController@passwordReset')->name('passwordReset');

Route::resource('comment','CommentsController');

Route::resource('questions','QuestionsController',['names' => [
    'create' => 'question.create',
    'show'   => 'question.show'
]]);












