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
                'name' => 'required|string|max:255',
                'type' => 'required|string|max:255',
                'document_type' => 'required|string|max:255',
                'document_number' => 'required|string|max:255',
                'status' => 'required|string|masx:255'
            ]);
            
            $data = $request->all();

            $this->service->create($data);

            return response()->json([
                'message' => 'Visitor successfully registered'
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
