<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Contacto;

use Illuminate\Database\QueryException;

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
        $contactos = Contacto::orderBy('id', 'desc')->get();
        return response()->json($contactos, 200);
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
