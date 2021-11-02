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

Route::post('auth/login', 'AuthController@login')->name('login');

Route::post('auth/refresh', 'AuthController@refresh')->name('refresh');


Route::group(['middleware' => ['apiJWT']], function (){

    Route::get('auth/me', 'AuthController@me')->name('me');
    Route::post('auth/logout', 'AuthController@logout')->name('logout');

    Route::get('matrizes-filiais', 'ClienteController@matrizesFiliais')->name('matrizesFiliais');


    //consultas
    Route::group(['prefix' => 'consultas', 'namespace' => 'Consulta'], function () {

        Route::post('/solicitar', 'ConsultaController@solicitar');

//        Route::prefix('courses')->group(function () {
//            Route::get('/', 'UserController@courses');
//            Route::get('/{id}', 'CourseController@show');
//        });

    });
    //consultas



});





