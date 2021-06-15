<?php

namespace App\Http\Controllers;

use App\Models\Estampa;
use App\Models\Preco;
use Illuminate\Http\Request;
use App\Models\Cores;

class CompraController extends Controller
{
    public function carrinho(Request $request)
    {
        $carrinho = $request->session()->get('carrinho', []);

        $custo_total=0;

        foreach($carrinho as $pedido){
            $custo_total += $pedido['preco'];
        }

        return view('compra.carrinho')
            ->with('carrinho', session('carrinho') ?? [])
            ->withCustoTotal($custo_total);
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

        $pedido_id = $request->pedido_id;

        $estampa_nome = $carrinho[$pedido_id]['estampa']->nome;
        $cor = $carrinho[$pedido_id]['cor']->nome;

        if (array_key_exists($pedido_id, $carrinho)) {
            unset($carrinho[$pedido_id]);
            $request->session()->put('carrinho', $carrinho);
            return back()
                ->with('alert-msg', 'O seu pedido  [  " Estampa : ' .$estampa_nome." | Cor: ".$cor . ' " ] foi completamente removido')
                ->with('alert-type', 'success');
        }
        return back()
            ->with('alert-msg', 'O seu pedido  [  " Estampa : ' .$estampa_nome." | Cor: ".$cor . ' " ]  já não existia no carrinho!')
            ->with('alert-type', 'warning'); 
        
    }

    public function update_pedido(Request $request)
    {
        $pedido_id = $request->pedido_id;
        $preco = Preco::first();
        
        $carrinho = $request->session()->get('carrinho', []);

        $estampa_nome = $carrinho[$pedido_id]['estampa']->nome;
        $cor = $carrinho[$pedido_id]['cor']->nome;

        $qtd = $carrinho[$pedido_id]['qtd'] ?? 0;
        $qtd += $request->quantidade;

        if ($request->quantidade < 0) {
            $msg = 'Foi removida [ ' . -$request->quantidade . ' ] quantidade ao seu pedido [  " Estampa : ' .$estampa_nome." | Cor: ".$cor . ' " ]';
        } elseif ($request->quantidade > 0) {
            $msg = 'Foi adicionada [ ' . $request->quantidade . ' ] quantidade ao seu pedido [  " Estampa : ' .$estampa_nome." | Cor: ".$cor . ' " ]';
        }
        if ($qtd <= 0) {
            unset($carrinho[$pedido_id]);
            $msg = 'O seu pedido foi completamente removido [  " Estampa : ' .$estampa_nome." | Cor: ".$cor . ' " ]';
        } else {

            if($carrinho[$pedido_id]['estampa']->cliente_id)
            {
                $preco = $request->quantidade < 5 ? ($preco->preco_un_proprio * $qtd) : ($preco->preco_un_proprio_desconto * $qtd);
    
            }
            else
            {
                $preco = $request->quantidade < 5 ? ($preco->preco_un_catalogo * $qtd) : ($preco->preco_un_catalogo_desconto * $qtd);
            }

            $carrinho[$pedido_id]['qtd'] = $qtd;    
            $carrinho[$pedido_id]['preco'] = $preco;   
        }
        $request->session()->put('carrinho', $carrinho);
        return back()
            ->with('alert-msg', $msg)
            ->with('alert-type', 'success');
    }
}
