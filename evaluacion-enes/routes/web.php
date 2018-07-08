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
Route::get('/', function () {
    return view('welcome');
});


Route::group([ 'middleware' => ['api', 'cors'], 'namespace' => $this->namespace, 'prefix' => 'api', ], function ($router) { 
    Route::post('/auth', 'AuthController@Autenticar');
<<<<<<< HEAD
    Route::get('/students', 'EstudianteController@index');
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
=======
    Route::get('/students', 'EstudianteController@index'); 
});
>>>>>>> ddecb60260a5abe60f52a1d3e936713b346e5771
