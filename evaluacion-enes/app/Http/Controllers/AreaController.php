<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Area;

class AreaController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['Autenticar']]);
    }

    public function index(){
        $areas = Area::orderBy('name', 'asc')->where('id', '<>', '1')->where('id', '<>', '2')->get();
        return response()->json(['areas' => $areas], 200);
    }
}
