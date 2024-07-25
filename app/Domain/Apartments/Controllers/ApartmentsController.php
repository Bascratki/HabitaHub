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
                'block_id' => 'required|integer',
                'number' => 'required|string|max:255',
                'floor' => 'required|string|max:255',
                'status' => 'required|string|max:255'
            ]);

            $data = $request->all();

            $this->service->create($data);

            return response()->json([
                'message' => 'Apartment successfully registered'
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
