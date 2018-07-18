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
    Route::post('/student', 'EstudianteController@ingresarAlumno'); 
    Route::put('/student/enable/{id}', 'EstudianteController@habilitado'); 
    Route::put('/student/info', 'EstudianteController@updateInformation'); 
    
    Route::get('/class', 'ClaseController@index');

    Route::post('/asistencia', 'AsistenciaController@store');
    Route::get('/asistencia/clase/{id}', 'AsistenciaController@getAsistenciasByClase');
    Route::get('/asistencia/alumno/{id}', 'AsistenciaController@show');

    Route::get('/teachers', 'DocenteController@index');
    Route::get('/teacher/all', 'DocenteController@show');
    Route::get('/teacher', 'DocenteController@getDocentesActive');
    Route::post('/teacher', 'DocenteController@store');
    Route::put('/teacher/{id}', 'DocenteController@update');
    Route::put('/teacher/enable/{id}', 'DocenteController@habilitar');
    
    Route::get('/periodo', 'PeriodoAcademicoController@index');
    Route::post('/periodo', 'PeriodoAcademicoController@store');
    Route::put('/periodo/enable/{id}', 'PeriodoAcademicoController@habilitado');
    Route::put('/periodo/{id}', 'PeriodoAcademicoController@update');

    Route::get('/paralelo', 'ParaleloController@index');
    Route::post('/paralelo', 'ParaleloController@store');
    Route::put('/paralelo/active/{id}', 'ParaleloController@activarParalelo');
    Route::put('/paralelo/desactive/{id}', 'ParaleloController@desactivarParalelo');
    Route::put('/paralelo/{id}', 'ParaleloController@update');

    Route::put('/profile/admin', 'AdministradorController@updateProfileAdmin');
    Route::put('/profile/teacher', 'DocenteController@updateProfileDocente');
    
    Route::get('/dominio', 'AreaController@index');
    Route::post('/dominio', 'AreaController@store');
    Route::put('/dominio/{id}', 'AreaController@update');
    
    Route::get('/contact', 'ContactoController@index');
    Route::post('/contact', 'ContactoController@store');
    
    Route::get('/user', 'UserController@getUserAuth');
    Route::get('/area/user', 'UserController@getAreaUser');
    Route::get('/periodo/user', 'UserController@getPeriodoUser');
    Route::get('/paralelo/user', 'UserController@getParaleloUser');
    Route::get('/rol/user', 'UserController@getRolUser');
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