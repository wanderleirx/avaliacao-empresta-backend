<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ConveniosController extends Controller
{
    public function find(Request $request, Response $response)
    {
        try {
            $convenios = json_decode(file_get_contents(storage_path('app/public/Models/convenios.json')), true);
            return response()->json($convenios, 200);
        } catch (\Exception $e) {
            response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
