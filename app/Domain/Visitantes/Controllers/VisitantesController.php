<?php

namespace App\Domain\Visitantes\Controllers;

use App\Domain\Visitantes\Services\VisitantesService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class VisitantesController extends Controller
{
    public function __construct(
        private VisitantesService $service
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
                'nome' => 'required|string',
                'tipo' => 'required|string',
                'documento_tipo' => 'required|string',
                'documento_numero' => 'required|string',
            ]);
            
            $data = $request->all();

            $this->service->create($data);

            return response()->json([
                'message' => 'Visitante cadastrado com sucesso'
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
