<?php

namespace App\Domain\Apartments\Controllers;

use App\Domain\Apartments\Services\ApartmentsService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class ApartmentsController extends Controller
{
    public function __construct(
        private ApartmentsService $service
    ) {
    }

    public function index(): JsonResponse
    {
        try {

            $apartment = $this->service->all();

            return response()->json([
                'apartments' => $apartment
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
                'user_id' => 'required|integer',
                'block_id' => 'required|integer',
                'number' => 'required|integer',
                'floor' => 'required|integer',
            ]);

            $apartment = $request->all();

            $verificaUserBlockNumberFloor = $this->service->findByUserBlockNumberFloor($apartment['user_id'], $apartment['block_id'], $apartment['number'], $apartment['floor']);

            if ($verificaUserBlockNumberFloor) throw new \Exception('Apartamento já cadastrado');

            $this->service->create($apartment);

            return response()->json([
                'success' => 'Apartamento criado com sucesso'
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
            $apartment = $this->service->find($id);

            if (!$apartment) throw new \Exception('Apartamento não encontrado');
            
            return response()->json([
                'apartment' => $apartment
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
                'user_id' => 'required|integer',
                'block_id' => 'required|integer',
                'number' => 'required|integer',
                'floor' => 'required|integer',
            ]);

            $apartment = $this->service->find($id);

            if (!$apartment) throw new \Exception('Apartamento não encontrado');

            $this->service->update($id, $request->only(
                'user_id',
                'block_id',
                'number',
                'floor'
            ));

            return response()->json([
                'success' => 'Apartamento atualizado com sucesso'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete($id): JsonResponse
    {
        try {
            $apartment = $this->service->delete($id);

            if (!$apartment) throw new \Exception('Apartamento não encontrado');

            return response()->json([
                'succes' => 'Apartamento deletado com sucesso'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}