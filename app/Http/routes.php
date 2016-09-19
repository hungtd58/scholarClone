<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('showalljs', 'JSController@showalljs');
Route::get('checkinfo/{id}/{titlecheck}/{mla}/{apa}/{chicago}/{harvard}/{vancouver}', 'InfoJSController@checkinfo');
Route::get('saveciteandclusterid/{id}', 'InfoJSController@saveciteandclusterid');
Route::get('savecitetojs/{id}/{titlecheck}/{mla}/{apa}/{chicago}/{harvard}/{vancouver}', 'CiteToJSController@savecitetojs');

Route::get('alljs', 'JSController@alljs');
Route::get('detail/{js_id}', 'InfoJSController@detail');
Route::get('citetojs/{js_id}', 'CiteToJSController@citetojs');
Route::get('search', 'JSController@search');

Route::get('error', function(){
    return view('error');
});