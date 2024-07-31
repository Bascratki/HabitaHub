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

            $data = $this->service->all();

            return response()->json([
                'data' => $data
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
                'role_id' => 'required|exists:roles,id',
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'cpf' => 'required|string|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            $request->merge([
                'password' => Hash::make($request->password)
            ]);

            $data = $this->service->create($request->all());

            return response()->json([
                'data' => $data
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

            $data = $this->service->find($id);

            if (!$data) throw new \Exception('Usuário não encontrado');

            return response()->json([
                'data' => $data
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
            $this->service->update($id, $request->all());

            return response()->json([
                'success' => 'Usuário atualizado com sucesso!',
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
            $data = $this->service->delete($id);

            if (!$data) throw new \Exception('Usuário não encontrado');

            return response()->json([
                'success' => 'Usuário deletado com sucesso!'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
