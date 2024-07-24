<?php

namespace App\Domain\Usuarios\Controllers;

use App\Domain\Usuarios\Services\UsuariosService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    public function __construct(
        private UsuariosService $service
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

    public function show($id): JsonResponse
    {
        try {

            $data = $this->service->find($id);

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
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:usuarios',
                'password' => 'required|string',
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

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $data = $this->service->update($id, $request->all());

            return response()->json([
                'success' => 'Usuário atualizado com sucesso!',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Request $request): JsonResponse
    {
        try {
            $usuario = auth('api')->usuario();
            if (!Hash::check($request->password, $usuario->password)) {
                return response()->json([
                    'error' => 'Senha incorreta!'
                ], Response::HTTP_BAD_REQUEST);
            }

            $this->service->delete($usuario->id);

            return response()->json([
                'success' => 'Seu conta foi deletada com sucesso!'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
