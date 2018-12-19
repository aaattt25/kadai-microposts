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
Route::group(['middleware' => 'auth'],function(){
    Route::resource('users','UsersController',['only' => ['index', 'show']]);
    
    // 前にIdをつけフォロー/アンフォローをルーティング
    Route::group(['prefix' => 'users/{id}'], function(){
        Route::post('follow','UserFollowController@store')->name('user.follow');
        Route::delete('unfollow', 'UserFollowController@destroy')->name('user.unfollow');
    // 前にIdをつけフォローしている人を一覧表示するルーティング
        Route::get('followings','UsersController@followings')->name('users.followings');
     // 前にIdをつけフォロワーを一覧表示するルーティング
        Route::get('followers','UsersController@followers')->name('users.followers');
     //お気に入りの機能@favoritesアクション
     Route::get('favarites','UsersController@favorites')->name('users.favorites');
    });
    
    // 追加
    Route::group(['prefix' => 'microposts/{id}'], function(){
       Route::post('favorite', 'FavoritesController@store')->name('favorites.favorite');
       Route::delete('unfavorite','FavoritesController@destroy')->name('favorites.unfavorite');
    });
    Route::resource('microposts','MicropostsController',['only'=>['store','destroy']]);
});