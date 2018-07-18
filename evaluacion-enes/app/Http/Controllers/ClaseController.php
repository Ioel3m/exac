<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Clase;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\QueryException;

use Illuminate\Support\Facades\Auth;

class ClaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['Autenticar']]);
    }

    public function index(){
        $clases = Clase::where('condicion', '=', '1')
            ->where('idprofesor', '=', Auth::user()->id)
            ->orderBy('id', 'desc')->get();
        return response()->json($clases, 200);
    }
}
