<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Contacto;

use Illuminate\Database\QueryException;

use Carbon\Carbon;

use DB;

class ContactoAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['Autenticar']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date = Carbon::now('America/Lima');

        $FechaActual = strtotime($date->toDateTimeString());
        $contactos = Contacto::orderBy('id', 'desc')->get();
        
        $arrayContactos = [];
        foreach ($contactos as $key => $contacto) {
            $c = new Contacto();
            $c->id = $contacto['id'];
            $c->nombres = $contacto['nombres'];
            $c->telefono = $contacto['telefono'];
            $c->correo = $contacto['correo'];
            $c->mensaje = $contacto['mensaje'];
            $c->created_at = $contacto['created_at'];
            $c->updated_at = $contacto['updated_at'];
            
            $FechaRegistro = strtotime($c->created_at);
            
            $tiempoTranscurridosRegistro = $FechaActual - $FechaRegistro;
            $dias = floor($tiempoTranscurridosRegistro / 86400);
            
            $created_day = '';
            
            if($dias == 0){
                $created_day = 'Hoy';
            }else if($dias == 1){
                $created_day = 'Ayer';
            }else if($dias > 1 && $dias < 28){
                $created_day = 'Hace '.$dias.' días';
            }else if($dias >= 28 && $dias <= 31){
                $created_day = 'Hace aproximadamente un mes';
            }else{
                $created_day = ($c->created_at == null) ? $c->created_at : $c->created_at->toFormattedDateString();
            }
            $arrayContactos[] = [   
                'id' => $c->id, 
                'nombres' => $c->nombres,
                'telefono' => $c->telefono,
                'correo' => $c->correo,
                'mensaje' => $c->mensaje,
                'created_at' => ($c->created_at == null) ? $c->created_at : $c->created_at->toDateTimeString(),
                'updated_at' => ($c->updated_at == null) ? $c->updated_at : $c->updated_at->toDateTimeString(),
                'created_day' => $created_day
            ];
        }
            
        return response()->json($arrayContactos, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = Contacto::findOrFail($id);
        $contact->delete();
        return response()->json(['success' => 'SE HA BORRADO ESTE COMENTARIO']);
    }
}
