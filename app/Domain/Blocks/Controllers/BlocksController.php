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
            $block = $this->service->all();

            return response()->json([
                'blocks' => $block
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
            
            $block = $request->all();

            $verificaBlocoCondominio = $this->service->findByBlockAndCondominium($block['num_block'], $block['condominium_id']);

            if ($verificaBlocoCondominio) throw new \Exception('Bloco já cadastrado neste condomínio');

            $this->service->create($block);

            return response()->json([
                'succes' => 'Bloco cadastrado com sucesso'
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
            $block = $this->service->find($id);

            if (!$block) throw new \Exception('Bloco não encontrado');

            return response()->json([
                'block' => $block,
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
                'condominium_id' => 'required|integer',
                'num_block' => 'required|integer',
                'num_apartments' => 'required|integer',
            ]);

            $block = $this->service->find($id);

            if (!$block) throw new \Exception('Bloco não encontrado');

            $verificaBlocoCondominio = $this->service->findByBlockAndCondominium($request->num_block, $request->condominium_id);

            if ($verificaBlocoCondominio) throw new \Exception('Bloco já cadastrado neste condomínio');

            $this->service->update($id, $request->only(
                'condominium_id',
                'num_block',
                'num_apartments',
            ));

            return response()->json([
                'success' => 'Bloco atualizado com sucesso'
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
            $block = $this->service->find($id);

            if (!$block) throw new \Exception('Bloco não encontrado');

            $this->service->delete($id);
            
            return response()->json([
                'success' => 'Bloco deletado com sucesso'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
}
