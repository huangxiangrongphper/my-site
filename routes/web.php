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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/deploy','DeploymentController@deploy');

Route::any('/wechat', 'WeChatController@serve');

Route::get('/image','MaterialController@image');
Route::get('/audio','MaterialController@audio');
