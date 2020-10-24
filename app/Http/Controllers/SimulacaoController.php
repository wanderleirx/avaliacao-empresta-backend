<?php

namespace App\Http\Controllers;

use App\Http\Requests\SimulacaoRequest;

class SimulacaoController extends Controller
{
    public function simulacao(SimulacaoRequest $request)
    {
        try {
            $valor_emprestimo = $request->valor_emprestimo;
            $instituicoes = $request->instituicoes;
            $convenios = $request->convenios;
            $parcelas = $request->parcelas;
            $simulacoes = $this->simular($valor_emprestimo);
            $simulacoes = $this->filtrar($simulacoes, $instituicoes, $convenios, $parcelas);
            return response()->json($simulacoes, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function getTaxasInstituicoes()
    {
        return json_decode(file_get_contents(storage_path('app/public/Models/taxas_instituicoes.json')), true);
    }

    private function simular($valor_emprestimo)
    {
        $simulacoes = [];
        $taxas = $this->getTaxasInstituicoes();

        foreach($taxas as $taxa) {
            $instituicao = $taxa['instituicao'];

            if(!isset($simulacoes[$instituicao])) {
                $simulacoes[$instituicao] = [];
            }

            $simulacoes[$instituicao][] = [
                'taxa' => $taxa['taxaJuros'],
                'parcelas' => $taxa['parcelas'],
                'valor_parcela' => round($valor_emprestimo * $taxa['coeficiente'], 2),
                'convenio' => $taxa['convenio'],
            ];
        }

        return $simulacoes;
    }

    private function filtrar($simulacoes, $instituicoes, $convenios, $parcelas)
    {
        foreach($simulacoes as $instituicao => &$value) {
            foreach ($value as $index2 => $simulacao) {
                if(!empty($convenios) && !is_numeric(array_search($simulacao['convenio'], $convenios)) ) {
                    unset($value[$index2]);
                }
                if($parcelas && $parcelas != $simulacao['parcelas']) {
                    unset($value[$index2]);
                }
            }
            if(!empty($instituicoes) && !is_numeric(array_search($instituicao, $instituicoes))
                || empty($simulacoes[$instituicao])) {
                unset($simulacoes[$instituicao]);
            }
            $value = array_values($value);
        }

        return $simulacoes;
    }
}
