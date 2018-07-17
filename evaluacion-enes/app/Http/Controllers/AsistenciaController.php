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

    public function getAsistenciasByClase($id){
        //$idclase = DB::table('clases')->max('id');
        $idclase = $id;
        $asistencias = Asistencia::join('clases', 'clases.id', '=', 'asistencias.idclase')
            ->join('users', 'users.id', '=', 'asistencias.idalumno')
            ->select('clases.tema', 'users.id', 'users.nombres', 'users.apellidos', 'users.nickname', 'users.email', 'users.telefono', 'users.direccion', 'users.fecha_nacimiento', 'users.estado_civil', 'users.informacion_personal', 'users.condicion', 'asistencias.asistio', 'asistencias.fuga', 'asistencias.observacion', 'asistencias.created_at', 'asistencias.updated_at')
            ->where('users.idparalelo', '=', Auth::user()->idparalelo)
            ->where('users.idperiodo', '=', Auth::user()->idperiodo)
            ->where('users.idrol','=', '2')
            ->where('users.condicion', '=', '1')
            ->where('clases.id', '=', $idclase)
            ->orderBy('users.apellidos', 'users.nombres', 'asc')
            ->get();
        return response()->json(['asistencias' => $asistencias], 200);
    }

    public function show($id){
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
        return response()->json(['asistencias' => $asistencias], 200);
    }

    public function store(Request $request){
        try{
            DB::beginTransaction();
                $clase = new Clase();
                $clase->tema = $request->tema;
                $clase->condicion = 1;
                $clase->idprofesor = Auth::user()->id;
                $clase->save();

                $totalAsistidos = 0;
                $totalFaltaron = 0;
                
                $asistencias = $request->asistencias;
                
                foreach ($asistencias as $as => $asistencia) {
                    $asist = new Asistencia();
                    $asist->asistio = $asistencia['asistio'];
                    $asist->fuga = "0";
                    $asist->observacion = $asistencia['observacion'];
                    $asist->idalumno = $asistencia['idalumno'];
                    $asist->idclase = $clase->id;

                    if ($asistencia['asistio']) {
                        $totalAsistidos += 1;
                    }else{
                        $totalFaltaron += 1;
                    }
                    $asist->save();
                }
            DB::commit();
            return response()->json(['success' => 'SE HA TOMADO ASISTENCIA', 'asistidos' => $totalAsistidos, 'faltaron' => $totalFaltaron], 200);
        }catch(QueryException $ex){
            DB::rollBack();
            return response()->json($e, 500);
        }
    }
}
