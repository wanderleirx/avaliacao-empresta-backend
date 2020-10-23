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
            $instituicoes = $request->instituicoes;
            $convenios = $request->convenios;
            $parcela = $request->parcela;
            
            $simulacoes = $this->simular($valor_emprestimo);
            
            $data = [];
            
            foreach($simulacoes as $index => $value) {
                if(empty($instituicoes) || array_search($index, $instituicoes) !== false) {
                    var_dump($value);die;
                    $data[$index] = $value;
                }
            }
            var_dump($data);die;
            
            // if(empty($convenios) || array_search($value['convenio'], $convenios) !== false) {
            //     $data[$index][] = $value;
            // }
            
            
            return response()->json([''], 200);
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
}
