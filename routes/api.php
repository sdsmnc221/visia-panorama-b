<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
** Basic Routes for a RESTful service:
**
**/
 
Route::get('/datasets/all', 'APIController@datasetsIndex');
Route::get('/datasets/featured', 'APIController@datasetsFeatured');
Route::get('/datasets/{id}', 'APIController@datasetsOne')->middleware('cors');

Route::get('/authors/all', 'APIController@authorsIndex');
Route::get('/authors/{id}', 'APIController@authorsOne');
Route::get('/authors/i/{id}', 'APIController@authorsImg');
Route::get('/authors/w/{id}', 'APIController@authorsWorks');

Route::get('/content/{query}', 'APIController@content');

 
