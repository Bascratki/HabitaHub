<?php

namespace App\Domain\Authentication\Controllers;

use App\Domain\Authentication\Services\AuthenticationService;
use Illuminate\Http\Request;
use App\Domain\Emails\Entities\Emails;

class AuthenticationController
{
    public function __construct(
        private AuthenticationService $service,
        private Emails $sendMail,
    ) {
        $this->sendMail = new Emails();
    }

    public function register(Request $request)
    {
        $user = $this->service->register($request->all());

        $token = auth('api')->login($user);
        return $this->respondWithToken($token);
    }

    public function login(Request $request)
    {
        $token = auth('api')->attempt(['email' => $request->email, 'password' => $request->password]);

        if (!$token) return response()->json(['error' => 'Usuário e/ou senha inválido(s)'], 400);
        return $this->respondWithToken($token);
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
