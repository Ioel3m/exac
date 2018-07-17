<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use App\Area;

use App\PeriodoAcademico;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\QueryException;

use Illuminate\Support\Facades\Auth;

class AdministradorController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['Autenticar']]);
    }

    public function updateProfileAdmin(Request $request){
        try{
            $docente = User::findOrFail(Auth::user()->id);
            $docente->nombres = $request->nombres;
            $docente->apellidos = $request->apellidos;
            $docente->cedula = $request->cedula;
            $docente->nickname = $request->nickname;
            $docente->email = $request->email;
            $docente->password = Hash::make($request->password);
            $docente->telefono = $request->telefono;
            $docente->direccion = $request->direccion;
            $docente->fecha_nacimiento = $request->fecha_nacimiento;
            $docente->estado_civil = $request->estado_civil;
            $docente->informacion_personal = 1;
            $docente->condicion = 1;
        
            $docente->save();
            return response()->json(['success' => 'Perfil del administrador actualizado'], 200);   

        }catch(QueryException $e){
            return response()->json($e, 500);
        }
    }
}
