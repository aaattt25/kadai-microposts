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

Route::get('/', 'MicropostsController@index');   //上書き


// ユーザー登録
Route::get('signup','Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup','Auth\RegisterController@register')->name('signup.post');

// ログイン認証
Route::get('login','Auth\LoginController@showLoginForm')->name('ligin');
Route::post('login','Auth\LoginController@login')->name('login.post');
Route::get('logout','Auth\LoginController@logout')->name('logout.get');

// ユーザー機能
//ルーティンググループで認証した人だけfunction以下のルーティングできる
Route::group([],function(){
    Route::resource('users','UsersController',['only' => ['index', 'show']]);
    Route::resource('microposts','MicropostsController',['only'=>['store','destroy']]);
});