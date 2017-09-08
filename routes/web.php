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
    //return view('welcome');
    return view('index');
});


route::get('/programList', 'programListController@index');
route::post('/programListSave', 'programListController@insert');
route::post('/ajaxCheck', 'programListController@ajaxCheck');
route::post('/ajaxList', 'programListController@ajaxList');
route::post('/ajaxUpdate', 'programListController@ajaxUpdate');
route::post('/ajaxSortUpdate', 'programListController@ajaxSortUpdate');