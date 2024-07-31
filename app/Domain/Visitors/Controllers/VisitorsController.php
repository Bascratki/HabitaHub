<?php

namespace App\Domain\Visitors\Controllers;

use App\Domain\Visitors\Services\VisitorsService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class VisitorsController extends Controller
{
    public function __construct(
        private VisitorsService $service
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
                'apartment_id' => 'required|integer',
                'condominium_id' => 'required|integer',
                'name' => 'required|string',
                'type' => 'required|string',
                'document_type' => 'required|string',
                'document_number' => 'required|string',
            ]);
            
            $data = $request->all();

            $this->service->create($data);

            if ($request->type === 'visitor') {
                $message = 'Visitante criado com sucesso';
            } elseif ($request->type === 'provider') {
                $message = 'Fornecedor criado com sucesso';
            }

            return response()->json([
                'message' => $message
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

            if(!$data) {
                throw new \Exception('Visitando não encontrado');
            }

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
            $data = $this->service->update($id, $request->all());

            if (!$data) throw new \Exception('Visitante não encontrado');

            return response()->json([
                'message' => 'Visitante atualizado com sucesso'
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

            if (!$data) throw new \Exception('Visitante não encontrado');

            return response()->json([
                'message' => 'Visitante deletado com sucesso'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}