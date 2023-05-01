<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('login',array('as'=>'login',function(){
    return response()->json([
        'status' => 401  ]);
}));

Route::post('login',array('as'=>'login',function(){
    return response()->json([
        'status' => 401  ]);
}));


Route::post('/auth/login','App\Http\Controllers\AuthController@login');



/*** Usuaris */
Route::middleware('auth:sanctum')->post('/usuaris', 'App\Http\Controllers\UserController@store');
Route::get('/usuaris', 'App\Http\Controllers\UserController@index');
Route::get('/usuaris/{uid}', 'App\Http\Controllers\UserController@show');
Route::middleware('auth:sanctum')->patch('/usuaris', 'App\Http\Controllers\UserController@update');
Route::middleware('auth:sanctum')->delete('/usuaris/{uid}', 'App\Http\Controllers\UserController@destroy');


/** Colleccio */
Route::get('/jocs','App\Http\Controllers\ColeccioController@index');
Route::middleware('auth:sanctum')->post('/jocs','App\Http\Controllers\ColeccioController@store');
Route::get('/jocs/bggsearchbyname/{query}','App\Http\Controllers\ColeccioController@searchBggByName');
Route::get('/jocs/{jocId}', 'App\Http\Controllers\ColeccioController@show');
Route::middleware('auth:sanctum')->delete('/jocs/{jocId}', 'App\Http\Controllers\ColeccioController@destroy');
Route::middleware('auth:sanctum')->patch('/jocs', 'App\Http\Controllers\ColeccioController@update');

/** Jocs */
Route::get('/jocs/bgg/{jocId}', 'App\Http\Controllers\JocController@show');
Route::get('/jocs/bggVideos/{jocId}', 'App\Http\Controllers\JocController@getVideos');



/*** PRESTECS */
Route::middleware('auth:sanctum')->post('/prestecs', 'App\Http\Controllers\PrestecController@store');
Route::get('/prestecs', 'App\Http\Controllers\PrestecController@index');
Route::get('/prestecs/{prestecId}', 'App\Http\Controllers\PrestecController@show');
Route::middleware('auth:sanctum')->patch('/prestecs', 'App\Http\Controllers\PrestecController@update');
Route::middleware('auth:sanctum')->delete('/prestecs/{prestecId}', 'App\Http\Controllers\PrestecController@destroy');


/*** PARTIDES */
Route::middleware('auth:sanctum')->post('/partides', 'App\Http\Controllers\PartidaController@store');
Route::get('/partides', 'App\Http\Controllers\PartidaController@index');
Route::get('/partides/{partidaId}', 'App\Http\Controllers\PartidaController@show');
Route::middleware('auth:sanctum')->patch('/partides', 'App\Http\Controllers\PartidaController@update');
Route::middleware('auth:sanctum')->delete('/partides/{partidaId}', 'App\Http\Controllers\PartidaController@destroy');

/*** PARTICIPANT */
Route::middleware('auth:sanctum')->post('/partides/addParticipant', 'App\Http\Controllers\ParticipantController@store');
Route::middleware('auth:sanctum')->post('/partides/delParticipant', 'App\Http\Controllers\ParticipantController@destroy');

/*** DATES Partides */
Route::get('/partides/getDates/{partidaId}', 'App\Http\Controllers\DataPartidaController@show');
Route::middleware('auth:sanctum')->post('/partides/addDate', 'App\Http\Controllers\DataPartidaController@store');
Route::middleware('auth:sanctum')->post('/partides/delDate', 'App\Http\Controllers\DataPartidaController@destroy');


/*** DATES Participants */
Route::middleware('auth:sanctum')->post('/partides/addDateParticipant', 'App\Http\Controllers\DataParticipantController@store');
Route::middleware('auth:sanctum')->post('/partides/delDateParticipant', 'App\Http\Controllers\DataParticipantController@destroy');