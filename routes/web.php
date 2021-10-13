<?php

use Illuminate\Support\Facades\Route;

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

///api/brands: [brand1{[models]}, brand2]
///api/models: [m1{brand}, m2]
///api/brands/{id}/models : GET
///api/brands/{id}/models/{id} : GET
//
///api/brands/{id}: GET, POST, PATCH
///api/models/{id}: -//-
