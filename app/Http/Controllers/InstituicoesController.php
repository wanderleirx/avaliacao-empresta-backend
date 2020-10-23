<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class InstituicoesController extends Controller
{
    /**
     * @param Request $request
     * @param Response $response
     * @return \Illuminate\Http\JsonResponse
     */
    public function find(Request $request, Response $response)
    {
        try {
            $instituicoes = json_decode(file_get_contents(storage_path('app/public/Models/instituicoes.json')), true);
            return response()->json($instituicoes, 200);
        } catch (\Exception $e) {
            response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
