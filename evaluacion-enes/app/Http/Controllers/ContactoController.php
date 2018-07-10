<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Contacto;

use Illuminate\Database\QueryException;

class ContactoController extends Controller
{
    public function index(){
        $contactos = Contacto::orderBy('id', 'desc')->get();
        return response()->json(['contactos' => $contactos], 200);
    }

    public function store(Request $request){
        try{
            $contacto = new Contacto();
            $contacto->nombres = $request->nombres;
            $contacto->teléfono = $request->telefono;
            $contacto->correo = $request->correo;
            $contacto->mensaje = $request->mensaje;
            $contacto->save();
            
            return response()->json(['succes' => 'Su información se ha enviado correctamente'], 200);
        }catch(QueryException $e){
            return response()->json($e, 500);
        }
    }
}
