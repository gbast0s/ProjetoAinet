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

        $carrinho = $request->session()->get('carrinho', []);


        if($estampa->cliente_id)
        {
            $preco = $request->quantidade < 5 ? ($preco->preco_un_proprio * $request->quantidade) + ($carrinho[$estampa->id."_".$request->cor."_".$request->tam]['preco'] ?? 0 )  : ($preco->preco_un_proprio_desconto * $request->quantidade) + ($carrinho[$estampa->id."_".$request->cor."_".$request->tam]['preco'] ?? 0 );

        }
        else
        {
            $preco = $request->quantidade < 5 ? ($preco->preco_un_catalogo * $request->quantidade) + ($carrinho[$estampa->id."_".$request->cor."_".$request->tam]['preco'] ?? 0 ) : ($preco->preco_un_catalogo_desconto * $request->quantidade) + ($carrinho[$estampa->id."_".$request->cor."_".$request->tam]['preco'] ?? 0 );
        }

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

    public function destroy_pedido(Request $request) {
        $carrinho = $request->session()->get('carrinho', []);

        dd($carrinho[$request->pedido_id]);
        
    }
}
