<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use App\Asistencia;

use App\Clase;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\QueryException;

use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

class AsistenciaController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['Autenticar']]);
    }

    public function getAsistenciasByClase($id)
    {
        //$idclase = DB::table('clases')->max('id');
        $idclase = $id;
        $asistencias = Asistencia::join('clases', 'clases.id', '=', 'asistencias.idclase')
            ->join('users', 'users.id', '=', 'asistencias.idalumno')
            ->select('clases.tema', 'users.id as idalumno', 'users.nombres', 'users.apellidos', 'users.nickname', 'users.email', 'users.telefono', 'users.direccion', 'users.fecha_nacimiento', 'users.estado_civil', 'users.informacion_personal', 'users.condicion', 'asistencias.asistio', 'asistencias.fuga', 'asistencias.observacion', 'asistencias.created_at', 'asistencias.updated_at')
            ->where('users.idparalelo', '=', Auth::user()->idparalelo)
            ->where('users.idperiodo', '=', Auth::user()->idperiodo)
            ->where('users.idrol','=', '2')
            ->where('users.condicion', '=', '1')
            ->where('clases.id', '=', $idclase)
            ->orderBy('users.apellidos', 'users.nombres', 'asc')
            ->get();
        return response()->json($asistencias, 200);
    }

    public function show($id)
    {
        $idalumno = $id;
        $asistencias = Asistencia::join('clases', 'clases.id', '=', 'asistencias.idclase')
            ->join('users', 'users.id', '=', 'asistencias.idalumno')
            ->select('clases.tema', 'users.id', 'users.nombres', 'users.apellidos', 'users.nickname', 'users.email', 'users.telefono', 'users.direccion', 'users.fecha_nacimiento', 'users.estado_civil', 'users.informacion_personal', 'users.condicion', 'asistencias.asistio', 'asistencias.fuga', 'asistencias.observacion', 'asistencias.created_at', 'asistencias.updated_at')
            ->where('users.idparalelo', '=', Auth::user()->idparalelo)
            ->where('users.idperiodo', '=', Auth::user()->idperiodo)
            ->where('users.idrol','=', '2')
            ->where('users.condicion', '=', '1')
            ->where('users.id', '=', $idalumno)
            ->orderBy('asistencias.id', 'desc')
            ->get();
        return response()->json($asistencias, 200);
    }

    public function update(Request $request, $id)
    {
        try{   
            $asist = Asistencia::findOrFail($id);
            $asist->asistio = $request->asistio;
            $asist->fuga = $request->fuga;
            $asist->observacion = $request->observacion;
            $asist->save();
        }catch(QueryException $e){
            return response()->json($e, 500);
        }
    }
}
