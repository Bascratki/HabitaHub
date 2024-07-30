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
                'email' => 'required|email|unique:users',
                'password' => 'required|min:4',
            ]);

            $request->merge([
                'role_id' => 1,
                'password' => Hash::make($request->password)
            ]);

            $user = $this->service->register($request->all());

            $token = auth('api')->login($user);

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
        $user = auth('api')->user();

        if (!$user) return response()->json(['error' => 'Você não está logado'], 400); 

        $token = auth('api')->tokenById($user->id);
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
        $user = auth('api')->user();
        $abi = [
            ['action' => 'manage', 'subject' => 'all']
        ];

        $dadosuser = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'photo' => $user->photo,
            'role' => 'admin',
            'ability' => $abi,
            'avatar' => 'https://ui-avatars.com/api/?name=' . str_replace(' ', '', $user->name) . '&color=7F9CF5&background=EBF4FF',
        ];

        return [
            'userData' => $dadosuser,
            'accessToken' => $token,
            'refreshToken' => $token,
            'expires_in' => auth('api')->factory()->getTTL() * 2400
        ];
    }
}
