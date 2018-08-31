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

Route::pattern('id', '[0-9]+');

Route::get('/dashboard', 'DashboardController@index');
Route::redirect('/', '/dashboard');

Route::get('/authors/all', 'AuthorsController@index');
Route::redirect('/authors', '/authors/all');
Route::post('/authors/all/filter', 'AJAXController@filter');

Route::get('/datasets/all', 'DatasetsController@index');
Route::redirect('/datasets', '/datasets/all');
Route::get('/datasets/{id}', 'DatasetsController@one');
Route::get('/datasets/cu/{mode}', 'DatasetsController@cu');
Route::post('/datasets/csv', 'AJAXController@csv');
Route::post('/datasets/all/filter', 'AJAXController@filter');
Route::post('/datasets/{id}/filter', 'AJAXController@filter');

Route::get('/categories/all', 'CategoriesController@index');
Route::redirect('/categories', '/categories/all');
Route::get('/categories/cu/{mode}', 'CategoriesController@cu');
Route::post('/categories/cu', 'AJAXController@cu');
Route::post('/categories/all/filter', 'AJAXController@filter');

Route::get('/test', function() { return view('test'); });
