<?php

namespace App\Http\Controllers;

use App\Http\Requests\SimulacaoRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SimulacaoController extends Controller
{
    public function simulacao(SimulacaoRequest $request)
    {
        try {
            $valor_emprestimo = $request->valor_emprestimo;
            return response()->json([''], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
