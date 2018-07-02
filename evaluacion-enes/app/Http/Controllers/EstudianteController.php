<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class EstudianteController extends Controller
{
    public function index(){
        $estudiantes = User::orderBy('users.id','desc')->get();   
        return $estudiantes;
    }
}
