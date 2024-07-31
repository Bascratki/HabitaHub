<?php

namespace App\Domain\Blocks\Controllers;

use App\Domain\Blocks\Services\BlocksService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class BlocksController extends Controller
{
    public function __construct(
        private BlocksService $service
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
                'condominium_id' => 'required|integer',
                'num_block' => 'required|integer',
                'num_apartments' => 'required|integer',
            ]);
            
            $data = $request->all();

            $this->service->create($data);

            return response()->json([
                'message' => 'Bloco cadastrado com sucesso'
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

            if (!$data) throw new \Exception('Bloco não encontrado');

            return response()->json([
                'data' => $data
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
            $this->service->update($id, $request->all());

            return response()->json([
                'message' => 'Bloco atualizado com sucesso'
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
            $$data = $this->service->delete($id);

            if (!$data) throw new \Exception('Bloco não encontrado');

            return response()->json([
                'message' => 'Bloco deletado com sucesso'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
}
