<?php

namespace App\Http\Controllers;

use App\Models\Estampa;
use App\Models\Preco;
use Illuminate\Http\Request;
use App\Models\Cores;

class CompraController extends Controller
{
    public function carrinho()
    {
        return view('compra.carrinho')
            ->with('carrinho', session('carrinho') ?? []);
    }

    public function checkout()
    {
        return view('compra.checkout');
    }

    public function store_compra(Request $request, Estampa $estampa)
    {

        $preco = Preco::first();
        $cor = Cores::where('codigo', $request->cor)->first();
       
        if($request->quantidade < 0)
        {
            $request->quantidade = 1;
        }

        if($estampa->cliente_id)
        {
            $preco = $request->quantidade < 5 ? ($preco->preco_un_proprio * $request->quantidade) : ($preco->preco_un_proprio_desconto * $request->quantidade);

        }
        else
        {
            $preco = $request->quantidade < 5 ? ($preco->preco_un_catalogo * $request->quantidade) : ($preco->preco_un_catalogo_desconto * $request->quantidade);
        }

        $carrinho = $request->session()->get('carrinho', []);
        $qtd = ($carrinho[$estampa->id."_".$request->cor."_".$request->tam]['qtd'] ?? 0) + $request->quantidade;
        $carrinho[$estampa->id."_".$request->cor."_".$request->tam] = [
            'id' => $estampa->id."_".$request->cor."_".$request->tam,
            'estampa' => $estampa,
            'cor' => $cor,
            'qtd' => $qtd,
            'tam' => $request->tam,
            'nome_estampa' => $estampa->nome,
            'preco' => $preco,
        ];

        $request->session()->put('carrinho', $carrinho);

        return back()
            ->with('alert-msg', 'A sua escolha foi adicionada ao carrinho!')
            ->with('alert-type', 'success');
    }

    public function destroy(Request $request)
    {
        $request->session()->forget('carrinho');
        return back()
            ->with('alert-msg', 'Carrinho foi limpo!')
            ->with('alert-type', 'danger');
    }
}
