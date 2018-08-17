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

    Route::get('/student', 'EstudianteController@index'); 
    Route::get('/student/all', 'EstudianteController@allStudent'); 
    Route::get('/students', 'EstudianteController@getStudents'); 
    Route::get('/student/{id}', 'EstudianteController@show'); 
    Route::post('/student', 'EstudianteController@store'); 
    Route::put('/student/enable/{id}', 'EstudianteController@habilitado'); 
    Route::put('/student/info', 'EstudianteController@updateInformation'); 
    Route::put('/student/edit/{id}', 'EstudianteController@edit'); 
    Route::put('/student/reset/{id}', 'EstudianteController@resetPassword'); 
    
    Route::get('/class', 'ClaseController@index');
    Route::post('/class', 'ClaseController@store');

    Route::put('/asistencia/{id}', 'AsistenciaController@update');
    Route::get('/asistencia/clase/{id}', 'AsistenciaController@getAsistenciasByClase');
    Route::get('/asistencia/alumno/{id}', 'AsistenciaController@show');

    Route::get('/teachers', 'DocenteController@index');
    Route::get('/teacher/all', 'DocenteController@show');
    Route::get('/teacher', 'DocenteController@getDocentesActive');
    Route::get('/teacher/{id}', 'DocenteController@search');
    Route::post('/teacher', 'DocenteController@store');
    Route::put('/teacher/{id}', 'DocenteController@update');
    Route::put('/teacher', 'DocenteController@updateProfileDocente');
    Route::put('/teacher/enable/{id}', 'DocenteController@habilitar');
    Route::put('/teacher/reset/{id}', 'DocenteController@resetPassword'); 

    Route::get('/periodo', 'PeriodoAcademicoController@index');
    Route::get('/periodo/{id}', 'PeriodoAcademicoController@show');
    Route::post('/periodo', 'PeriodoAcademicoController@store');
    Route::put('/periodo/enable/{id}', 'PeriodoAcademicoController@habilitado');
    Route::put('/periodo/{id}', 'PeriodoAcademicoController@update');

    Route::get('/paralelo', 'ParaleloController@index');
    Route::get('/paralelo/{id}', 'ParaleloController@show');
    Route::post('/paralelo', 'ParaleloController@store');
    Route::put('/paralelo/enable/{id}', 'ParaleloController@habilitado');
    Route::put('/paralelo/{id}', 'ParaleloController@update');

    Route::put('/profile/admin', 'AdministradorController@updateProfileAdmin');
    Route::put('/profile/teacher', 'DocenteController@updateProfileDocente');
    
    Route::get('/dominio', 'AreaController@index');
    Route::get('/dominio/{id}', 'AreaController@show');
    Route::post('/dominio', 'AreaController@store');
    Route::put('/dominio/{id}', 'AreaController@update');
    
    Route::get('/contact', 'ContactoAuthController@index');
    Route::post('/contact', 'ContactoController@store');
    Route::delete('/contact/{id}', 'ContactoAuthController@destroy');
    
    Route::get('/user', 'UserController@getUserAuth');
    Route::get('/area/user', 'UserController@getAreaUser');
    Route::get('/periodo/user', 'UserController@getPeriodoUser');
    Route::get('/paralelo/user', 'UserController@getParaleloUser');
    Route::get('/rol/user', 'UserController@getRolUser');

    Route::get('/publish', 'PublicacionController@index');
    Route::get('/publish/{id}', 'PublicacionController@show');
    Route::post('/publish', 'PublicacionController@store');
    Route::put('/publish/{id}', 'PublicacionController@update');
    Route::delete('/publish/{id}', 'PublicacionController@destroy');

    Route::get('/comments', 'ComentarioController@index');
    Route::get('/comments/publish/{id}', 'ComentarioController@showCommentsByPublish');
    Route::post('/comments', 'ComentarioController@store');
    Route::put('/comments/{id}', 'ComentarioController@update');
    Route::delete('/comments/{id}', 'ComentarioController@destroy');
});

Route::get('/newtoken', array('middleware' => ['cors', 'jwt.auth'], function() {
    if ( ! $user = \JWTAuth::parseToken()->authenticate() ) {
        return response()->json(['Usuario no encontrado'], 404);
    }
    $nickname = \JWTAuth::parseToken()->authenticate();
    $token = \JWTAuth::getToken();
    $newToken = \JWTAuth::refresh($token);
    return response()->json(['token' => $newToken, 'user' => $user], 200);
}));

Route::get('/validatetoken', array('middleware' => ['cors', 'jwt.auth'], function() {
    if ( ! $user = \JWTAuth::parseToken()->authenticate() ) {
        return response()->json(['Usuario no encontrado'], 404);
    }
    $nickname = \JWTAuth::parseToken()->authenticate();
    return response()->json(['rol' => $user->idrol, 'informacion_personal' => $user->informacion_personal], 200);
}));

/*
Route::group(['middleware' => ['api', 'cors'], 'namespace' => $this->namespace, 'prefix' => 'api'], function () {
    Route::post('/auth', 'AuthController@Autenticar');
    Route::get('/students', 'EstudianteController@index');
});*/