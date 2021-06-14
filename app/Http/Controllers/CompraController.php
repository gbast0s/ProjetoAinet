<?php

namespace App\Http\Controllers;

use App\Models\Estampa;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    public function carrinho()
    {
        return view('compra.carrinho');
    }

    public function checkout()
    {
        return view('compra.checkout');
    }

    public function store_compra(Request $request, Estampa $estampa)
    {
        dd($request->tam, $request->cor, $estampa->nome, $request->quantidade);

        $carrinho = $request->session()->get('carrinho', []);
        $qtd = ($carrinho[$estampa->id."_".$request->cor."_".$request->tam]['qtd'] ?? 0) + $request->quantidade;
        $carrinho[$estampa->id."_".$request->cor."_".$request->tam] = [
            'cor' => $request->cor,
            'qtd' => $qtd,
            'abreviatura' => $disciplina->abreviatura,
            'nome' => $disciplina->nome,
            'curso' => $disciplina->curso,
            'ano' => $disciplina->ano,
            'semestre' => $disciplina->semestre,
        ];
        // $request->session()->put('carrinho', $carrinho);
        // return back()
        //     ->with('alert-msg', 'Foi adicionada uma inscrição à disciplina "' . $disciplina->nome . '" ao carrinho! Quantidade de inscrições = ' .  $qtd)
        //     ->with('alert-type', 'success');
    }
}
