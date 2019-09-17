<?php


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Broadcast::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('invoice', function(){
    return view('invoice');
});

//Route::get('{path}','HomeController@index')->where( 'path', '([A-z\d-/_.]+)?' );
Route::group(['middleware'=>'roles','roles' => ['admin','coordinateur','major','demandeur','brancardier']],function(){
   
    Route::get('brancardier','Controller@brancardier');
    Route::get('acceuil','HomeController@intermediaire');

});
Route::group(['middleware'=>'roles','roles' => ['admin','coordinateur','major','demandeur']],function(){
    Route::get('demandeur','Controller@demandeur');
});
Route::group(['middleware'=>'roles','roles' => ['admin','coordinateur','major']],function(){
    Route::get('major','Controller@major');
});
Route::group(['middleware'=>'roles','roles' => ['admin','coordinateur']],function(){
    Route::get('coordinateur','Controller@coordinateur');
});
Route::group(['middleware'=>'roles','roles' => ['admin']],function(){
    Route::get('admin','Controller@admin');
});
Route::group(['middleware'=>'roles','roles' => ['not_active']],function(){
    Route::get('not_active','Controller@not_active');
});

