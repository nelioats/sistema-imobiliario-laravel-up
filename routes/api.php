<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['namespace' => 'Api', 'as' => 'api.'], function () {

    Route::post('/auth/login', 'AuthController@login')->name('login'); // a unica rota que nao precisamos verificar com middleware prq aq q ele ira se autenticar

    Route::group(['middleware' => ['apiJwt']], function () {

        Route::post('/me', 'AuthController@me')->name('me');
        Route::post('/auth/logout', 'AuthController@logout')->name('logout');

        Route::apiResource('/company', 'CompanyController'); //ja cria todas as rotas com seus names


    });
});
