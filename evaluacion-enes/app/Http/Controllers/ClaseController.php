<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Clase;

use App\Asistencia;

use App\User;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\QueryException;

use Illuminate\Support\Facades\Auth;

class ClaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['Autenticar']]);
    }

    public function index()
    {
        $clases = Clase::where('condicion', '=', '1')
            ->where('idprofesor', '=', Auth::user()->id)
            ->orderBy('id', 'desc')->get();
        return response()->json($clases, 200);
    }

    /*Docente creando recursos de asistencias*/ 
    public function store (Request $request)
    {
        try{
            DB::beginTransaction();
            $myStudents = User::join('roles', 'roles.id', '=', 'users.idrol')
                ->join('areas', 'areas.id', '=', 'users.idarea')
                ->join('paralelos', 'paralelos.id', '=', 'users.idparalelo')
                ->join('periodos_academicos', 'periodos_academicos.id', '=', 'users.idperiodo')
                ->select('users.id', 'areas.name', 'paralelos.id as idparalelo', 'paralelos.descripcion as paralelo', 'periodos_academicos.id as idperiodo', 'periodos_academicos.fecha_inicio', 'periodos_academicos.fecha_fin', 'roles.descripcion', 'users.cedula','users.nombres', 'users.apellidos', 'users.nickname', 'users.email', 'users.telefono', 'users.direccion', 'users.fecha_nacimiento', 'users.estado_civil', 'users.informacion_personal', 'users.condicion', 'users.created_at', 'users.updated_at')
                ->where('paralelos.id', '=', Auth::user()->idparalelo)
                ->where('periodos_academicos.id', '=', Auth::user()->idperiodo)
                ->where('users.idrol', '=', '2')
                ->where('users.condicion', '=', '1')
                ->where('users.informacion_personal', '=', '1')
                ->orderBy('users.id', 'desc')
                ->get();
            
            $clase = new Clase();
            $clase->tema = $request->tema;
            $clase->condicion = 1;
            $clase->idprofesor = Auth::user()->id;
            $clase->save();

            foreach ($myStudents as $key => $student) {
                $asist = new Asistencia();
                $asist->asistio = '1';
                $asist->fuga = '0';
                $asist->observacion = '';
                $asist->idalumno = $student['id'];
                $asist->idclase = $clase->id;
                $asist->save(); 
            }
            DB::commit();
            return response()->json(['success' => 'Se ha creado un nuevo tema de clase'], 200);  
        }catch(QueryException $ex){
            DB::rollBack();
            return response()->json($e, 500);
        }
    }
}
