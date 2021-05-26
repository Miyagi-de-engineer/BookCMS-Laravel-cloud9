<?php

use App\Book;
use Illuminate\Http\Request;



// 本の一覧表示(books.blade.php)
Route::get('/','BooksController@index');
// 本を登録
Route::post('/books','BooksController@store');
// 本の更新
Route::post('/booksedit/{books}','BooksController@edit');
// 本の更新処理
Route::post('/books/update','BooksController@update');
// 本の削除
Route::delete('/book/{book}','BooksController@destroy');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');