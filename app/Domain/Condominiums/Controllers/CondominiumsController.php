<?php

namespace App\Domain\Condominiums\Controllers;

use App\Domain\Condominiums\Services\CondominiumsService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class CondominiumsController extends Controller
{
    public function __construct(
        private CondominiumsService $service
    ) {
    }

    public function index(): JsonResponse
    {
        try {
            $condominium = $this->service->all();

            return response()->json([
                'condominiums' => $condominium
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
                'company_id' => 'required|integer',
                'name' => 'required|string',
                'address' => 'required|string',
                'cep' => 'required|string',
            ]);
            
            $condominium = $request->all();
            
            $this->service->create($condominium);

            return response()->json([
                'success' => 'Condomínio cadastrado com sucesso'
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Aqui deu erro', 'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show (int $id): JsonResponse
    {
        try {
            $condominium = $this->service->find($id);

            if (!$condominium) throw new \Exception('Condomínio não encontrado');

            return response()->json([
                'condominium' => $condominium
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $request->validate([
                'company_id' => 'required|integer',
                'name' => 'required|string',
                'address' => 'required|string',
            ]);

            $condominium = $this->service->find($id);

            if (!$condominium) throw new \Exception('Condomínio não encontrado');

            $this->service->update($id, $request->only(
                'company_id',
                'name',
                'address',
            ));

            return response()->json([
                'success' => 'Condomínio atualizado com sucesso'
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
            $condominium = $this->service->find($id);

            if (!$condominium) throw new \Exception('Condomínio não encontrado');

            $this->service->delete($id);

            return response()->json([
                'success' => 'Condomínio deletado com sucesso'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' =>$e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}