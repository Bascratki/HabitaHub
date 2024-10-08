<?php

namespace App\Domain\Companies\Controllers;

use App\Domain\Companies\Services\CompaniesService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class CompaniesController extends Controller
{
    public function __construct(
        private CompaniesService $service
    ) {
    }

    public function index(): JsonResponse
    {
        try {
            $company = $this->service->all();

            return response()->json([
                'companies' => $company,
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
                'name' => 'required|string',
                'phone' => 'required|string',
                'email' => 'required|string',
                'cnpj' => 'required|string',
            ]);
            
            $company = $request->all();

            $verifyCnpj = $this->service->findByCnpj($company['cnpj']);
        
            if ($verifyCnpj) throw new \Exception('CNPJ já cadastrado');

            $this->service->create($company);

            return response()->json([
                'success' => 'Empresa cadastrada com sucesso'
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    public function show(int $id): JsonResponse
    {
        try {
            $company = $this->service->find($id);

            if (!$company) throw new \Exception('Empresa não encontrada');

            return response()->json([
                'company' => $company,
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
                'name' => 'required|string',
                'phone' => 'required|string',
                'email' => 'required|string',
                'status' => 'required|string'
            ]);

            $company = $this->service->find($id);

            if (!$company) throw new \Exception('Empresa não encontrada');

            $this->service->update($id, $request->only(
                'name',
                'phone',
                'email',
                'status'
            ));

            return response()->json([
                'success' => 'Empresa atualizada com sucesso',
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
            $company = $this->service->find($id);
            
            if (!$company) throw new \Exception ('Empresa não encontrada');

            $this->service->delete($id);

            return response()->json([
                'success' => 'Empresa deletada com sucesso',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
