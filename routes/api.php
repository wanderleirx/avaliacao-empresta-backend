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

Route::namespace('App\\Http\\Controllers')->group(function (){
    Route::get('/instituicoes', 'InstituicoesController@findAll');
    Route::get('/convenios', 'ConveniosController@findAll');
    Route::post('/simulacao', 'SimulacaoController@simulacao');
});

