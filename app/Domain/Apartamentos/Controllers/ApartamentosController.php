<?php

namespace App\Domain\Apartamentos\Controllers;

use App\Domain\Apartamentos\Services\ApartamentosService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class ApartamentosController extends Controller
{
    public function __construct(
        private ApartamentosService $service
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
                'numero' => 'required',
                'andar' => 'required',
                'status' => 'required',
            ]);
            
            $data = $request->all();

            $this->service->create($data);

            return response()->json([
                'message' => 'Apartamento cadastrada com sucesso'
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
