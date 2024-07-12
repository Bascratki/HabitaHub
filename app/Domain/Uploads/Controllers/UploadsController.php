<?php

namespace App\Domain\Uploads\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class UploadsController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        if (!$request->file('file')->isValid()) {
            return response()->json(['error' => 'Arquivo não é válido'], 200);
        }

        if ($request->file('file')->getSize() > 1000000) {
            return response()->json(['error' => 'Tamanho do arquivo é maior que 1MB'], 200);
        }
        
        $extension = $request->file('file')->extension();
        
        if (!in_array($extension, ['jpg', 'jpeg', 'png', 'doc', 'docx', 'pdf'])) {
            return response()->json(['error' => 'Arquivo não é uma imagem'], 200);
        }

        $path = Storage::disk('Project')->put(env('WAS_CAMINHO'), $request->file('file'));
        $path = str_replace('Project/', '', $path);
        
        return response()->json([
            'mime' => $request->file('file')->getMimeType(),
            'url' => $path
        ], 200);
    }
}