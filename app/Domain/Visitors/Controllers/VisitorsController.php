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

            $visitor = $this->service->all();

            return response()->json([
                'visitor' => $visitor
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
            
            $visitor = $request->all();
    
            if ($this->service->verificaDocumento($request->document_type, $request->document_number)) {
                throw new \Exception('Documento já cadastrado');
            }
    
            $this->service->create($visitor);
    
            return response()->json([
                'success' => ($request->type === 'visitor') ? 'Visitante criado com sucesso' : 'Fornecedor criado com sucesso'
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
            $visitor = $this->service->find($id);

            if(!$visitor) {
                throw new \Exception('Visitando não encontrado');
            }

            return response()->json([
                'visitor' => $visitor
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
                'apartment_id' => 'required|integer',
                'condominium_id' => 'required|integer',
                'name' => 'required|string',
                'type' => 'required|string',
            ]);

            $visitor = $this->service->find($id);

            if (!$visitor) throw new \Exception('Visitante não encontrado');

            if ($request->type === 'visitor') {
                $visitor = $this->service->update($id, $request->only(
                    'apartment_id',
                    'condominium_id',
                    'name',
                    'type'
                ));
            
                return response()->json([
                    'success' => 'Visitante atualizado com sucesso'
                ], Response::HTTP_OK);
            } elseif ($request->type === 'provider') {
                $visitor = $this->service->update($id, $request->only(
                    'apartment_id',
                    'condominium_id',
                    'name',
                    'type'
                ));
            
                return response()->json([
                    'success' => 'Fornecedor atualizado com sucesso'
                ], Response::HTTP_OK);
            }
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(int $id): JsonResponse
    {
        try {
            $visitor = $this->service->find($id);

            if (!$visitor) throw new \Exception('Visitante não encontrado');

            if ($visitor->type === 'visitor') {
                $this->service->delete($id);

                return response()->json([
                    'success' => 'Visitante deletado com sucesso'
                ], Response::HTTP_OK);
            } elseif ($visitor->type === 'provider') {
                $this->service->delete($id);

                return response()->json([
                    'success' => 'Fornecedor deletado com sucesso'
                ], Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}