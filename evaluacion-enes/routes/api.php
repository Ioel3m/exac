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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['middleware' => 'cors'], function () { 
    Route::post('/auth', 'AuthController@Autenticar');
    Route::get('/students', 'EstudianteController@index'); 
    
    Route::get('/teacher', 'AdministradorController@index');
    Route::post('/teacher', 'AdministradorController@store');

    Route::get('/teacher/area/{id}', 'DocenteController@getAreaDocente');
    Route::get('/teacher/periodo/{id}', 'DocenteController@getPeriodoDocente');
    Route::get('/teacher/paralelo/{id}', 'DocenteController@getParaleloDocente');
    Route::get('/teacher/rol/{id}', 'DocenteController@getRolDocente');

    Route::get('/dominio', 'AreaController@index');
});

Route::get('/token', array('middleware' => ['cors', 'jwt.auth'], function() {
    if ( ! $user = \JWTAuth::parseToken()->authenticate() ) {
        return response()->json(['Usuario no encontrado'], 404);
    }
    $nickname = \JWTAuth::parseToken()->authenticate();
    $token = \JWTAuth::getToken();
    $newToken = \JWTAuth::refresh($token);
    return response()->json(['nickname' => $user->nickname, 'token' => $newToken], 200);
}));

/*
Route::group(['middleware' => ['api', 'cors'], 'namespace' => $this->namespace, 'prefix' => 'api'], function () {
    Route::post('/auth', 'AuthController@Autenticar');
    Route::get('/students', 'EstudianteController@index');
});*/