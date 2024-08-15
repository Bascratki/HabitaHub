<?php

namespace App\Domain\Users\Controllers;

use App\Domain\Users\Services\UsersService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function __construct(
        private UsersService $service
    ) {
    }

    public function index(): JsonResponse
    {
        try {
            $user = $this->service->all();

            return response()->json([
                'users' => $user
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'role_id' => 'required|integer',
                'name' => 'required|string',
                'phone' => 'required|string',
                'address' => 'required|string',
                'email' => 'required|string',
                'cpf' => 'required|string',
                'password' => 'required|string',
            ]);

            $request->merge([
                'password' => Hash::make($request->password)
            ]);

            $user = $request->all();

            $verificaCpf = $this->service->findByCpf($user['cpf']);

            if($verificaCpf) throw new \Exception ('CPF já cadastrado');

            $this->service->create($user);

            return response()->json([
                'success' => $user
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    public function show($id): JsonResponse
    {
        try {
            $user = $this->service->find($id);

            if (!$user) throw new \Exception('Usuário não encontrado');

            return response()->json([
                'user' => $user
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function update(Request $request, $id): JsonResponse
    {
        try {
            $request->validate([
                'role_id' => 'required|integer',
                'name' => 'required|string',
                'phone' => 'required|string',
                'address' => 'required|string',
                'email' => 'required|string',
                'password' => 'required|string',
            ]);

            $request->merge([
                'password' => Hash::make($request->password)
            ]);

            $user = $this->service->find($id);

            if (!$user) throw new \Exception ('Usuário não encontrado');

            $this->service->update($id, $request->only(
                'role_id',
                'name',
                'phone',
                'address',
                'email',
                'password'
            ));

            return response()->json([
                'success' => 'Usuário atualizado com sucesso'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(int $id): JsonResponse
    {
        try {
            $user = $this->service->find($id);

            if (!$user) throw new \Exception ('Usuário não encontrado');

            $this->service->delete($id);
            
            return response()->json([
                'success' => 'Usuário deletado com sucesso'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
