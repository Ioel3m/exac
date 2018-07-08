<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Tymon\JWTAuth\Facades\JWTAuth;
 
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function __construct()
    {
<<<<<<< HEAD
        $this->middleware('jwt.auth', ['except' => ['login']]);
    }


    public function Autenticar(Request $request){
        $credenciales = $request->only('nickname', 'password');
        $token = null;

        try{
            if (!$token = JWTAuth::attempt($credenciales)) {
                return response()->json(['error' => 'Las credenciales son incorrectas']);
=======
        //$this->middleware('jwt.auth', ['except' => ['login']]);
    }
 
    public function Autenticar(Request $request)
    {
        $credenciales = $request->only('nickname', 'password'); 
        try {
            if (! $token = JWTAuth::attempt($credenciales)) {
                return response()->json(['error' => 'Las credenciales son incorrectas'], 401);
>>>>>>> ddecb60260a5abe60f52a1d3e936713b346e5771
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Ha ocurrido un error interno en el servidor'], 500);
        }
 
        return response()->json(compact('token'));
    }

}
