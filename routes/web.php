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

// ページを表示させたいだけなのでHTTPメソッドget
Route::get('/','PostsController@index');

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

// 一覧画面
Route::get('/home','PostsController@index');

// ユーザー編集画面
Route::get('/users/edit', 'UsersController@edit');

// ユーザー更新画面
Route::post('/users/update', 'UsersController@update');

// 投稿新規画面
Route::get('/posts/new', 'PostsController@new')->name('new');

// 投稿新規処理
Route::post('/posts', 'PostsController@store');

// 投稿削除処理
 Route::get('/postsdelete/{post_id}', 'PostsController@destroy');
 
//  いいね処理
 Route::get('/posts/{post_id}/likes', 'LikesController@store');
 
//  いいね取消処理
Route::get('/likes/{like_id}', 'LikesController@destroy');

//  コメント投稿処理
Route::post('/posts/{comment_id}/comments','CommentsController@store');

//  コメント取消処理
Route::get('/comments/{comment_id}', 'CommentsController@destroy');

Route::post('/chat/show', 'ChatController@show')->name('chat.show');

// ユーザー詳細画面
Route::get('/users/{user_id}', 'UsersController@show');