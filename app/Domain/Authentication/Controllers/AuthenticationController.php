<?php

namespace App\Domain\Authentication\Controllers;

use App\Domain\Authentication\Services\AuthenticationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticationController
{
    public function __construct(
        private AuthenticationService $service,
    ) {
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:usuarios',
                'password' => 'required|min:6'
            ]);


            $request->merge([
                'funcao_id' => 1,
                'password' => Hash::make($request->password)
            ]);

            $usuario = $this->service->register($request->all());

            $token = auth('api')->login($usuario);

            return $this->respondWithToken($token);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function login(Request $request)
    {
        try { 
            $request->validate([
                'email' => 'required',
                'password' => 'required'
            ]);
            $token = auth('api')->attempt($request->only('email', 'password'));

            if (!$token) throw new \Exception('Usuário e/ou senha inválido(s)');

            return $this->respondWithToken($token);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Usuário e/ou senha inválido(s)'], 400);
        }
    }


    public function me(Request $request)
    {
        $usuario = auth('api')->usuario();

        if (!$usuario) return response()->json(['error' => 'Você não está logado'], 400); 

        $token = auth('api')->tokenById($usuario->id);
        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        $usuario = auth('api')->usuario();
        $abi = [
            ['action' => 'manage', 'subject' => 'all']
        ];

        $dadosusuario = [
            'id' => $usuario->id,
            'name' => $usuario->name,
            'email' => $usuario->email,
            'photo' => $usuario->photo,
            'role' => 'admin',
            'ability' => $abi,
            'avatar' => 'https://ui-avatars.com/api/?name=' . str_replace(' ', '', $usuario->name) . '&color=7F9CF5&background=EBF4FF',
        ];

        return [
            'usuarioData' => $dadosusuario,
            'accessToken' => $token,
            'refreshToken' => $token,
            'expires_in' => auth('api')->factory()->getTTL() * 2400
        ];
    }
}
