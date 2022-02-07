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

    Route::get('meus-usuarios', 'Auxiliar\UsuarioController@meusUsuarios')->name('meus-usuarios');

    Route::get('/materiais', 'MaterialController@index')->name('materiais');

    Route::get('/valores-mercadorias-autonomo', 'MaterialController@valoresMercadoriasAutonomo')->name('valores-mercadorias-autonomo');
    Route::get('/valores-mercadorias-rh', 'MaterialController@valoresMercadoriasRH')->name('valores-mercadorias-rh');
    Route::get('/valores-mercadorias-frota', 'MaterialController@valoresMercadoriasFrota')->name('valores-mercadorias-frota');
    Route::get('/valores-mercadorias-agregado', 'MaterialController@valoresMercadoriasAgregado')->name('valores-mercadorias-agregado');

    Route::get('veiculos', 'ClienteController@veiculos')->name('veiculos');

    Route::get('veiculos/marcas',   'ClienteController@marcas')->name('marcas');
    Route::get('veiculos/modelos',  'ClienteController@modelos')->name('modelos');


    //consultas
    Route::group(['prefix' => 'consultas', 'namespace' => 'Consulta'], function () {

        Route::post('/solicitar', 'ConsultaController@solicitar');

//        Route::prefix('courses')->group(function () {
//            Route::get('/', 'UserController@courses');
//            Route::get('/{id}', 'CourseController@show');
//        });

    });
    //consultas


    //pesquisas
    Route::group(['prefix' => 'pesquisas', 'namespace' => 'Pesquisa'], function () {




        Route::group(['prefix' => 'autonomo',], function () {

            Route::post('/',            'AutonomoController@create')->name('solicitar-pesquisa-autonomo');
            Route::post('/veiculo',     'AutonomoController@vehicle')->name('solicitar-pesquisa-autonomo-veiculo');



        });
    });
    //pesquisas



});





