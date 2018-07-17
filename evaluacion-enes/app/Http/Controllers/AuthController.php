<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Tymon\JWTAuth\Facades\JWTAuth;

use Tymon\JWTAuth\Exceptions\JWTException;

use Illuminate\Support\Facades\Auth;

use App\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['Autenticar']]);
    }

    public function Autenticar(Request $request)
    {
        $credenciales = $request->only('nickname', 'password'); 
        $user = null;
        try {
            if (! $token = JWTAuth::attempt($credenciales)) {
                return response()->json(['error' => 'Las credenciales son incorrectas'], 401);
            }
            
            $user = Auth::user();

            if ($user->condicion == 0) {
                return response()->json(['error' => 'El usuario '.$user->nickname.' está deshabilitado'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Ha ocurrido un error interno en el servidor'], 500);
        }
 
        return response()->json([compact('token'), 'user' => $user], 200);
    }

}
