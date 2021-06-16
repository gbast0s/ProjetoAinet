<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarrinhoPost;
use App\Models\Estampa;
use App\Models\Preco;
use Illuminate\Http\Request;
use App\Models\Cores;
use App\Models\Clientes;
use App\Models\Encomendas;
use App\Models\Tshirts;
use Illuminate\Support\Facades\Auth;

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

    public function checkout(Request $request)
    {
        $cliente = Clientes::where('id', Auth::user()->id)->first();

        $carrinho = $request->session()->get('carrinho', []);

        $custo_total=0;

        foreach($carrinho as $pedido){
            $custo_total += $pedido['preco'];
        }

        return view('compra.checkout')
            ->with('carrinho', session('carrinho') ?? [])
            ->withCustoTotal($custo_total)
            ->withCliente($cliente);
    }

    public function store_pedido(CarrinhoPost $request, Estampa $estampa)
    {

        $validatedData = $request->validated();

        $preco = Preco::first();
        $cor = Cores::where('codigo', $validatedData['cor'])->first();

        $carrinho = $request->session()->get('carrinho', []);


        if($estampa->cliente_id)
        {
            $preco_un = $validatedData['quantidade'] < 5 ? $preco->preco_un_proprio  : $preco->preco_un_proprio_desconto;
            $preco = $validatedData['quantidade'] < 5 ? ($preco->preco_un_proprio * $validatedData['quantidade']) + ($carrinho[$estampa->id."_".$validatedData['cor']."_".$validatedData['tam']]['preco'] ?? 0 )  : ($preco->preco_un_proprio_desconto * $validatedData['quantidade']) + ($carrinho[$estampa->id."_".$validatedData['cor']."_".$validatedData['tam']]['preco'] ?? 0 );

        }
        else
        {
            $preco_un = $validatedData['quantidade'] < 5 ? $preco->preco_un_catalogo  : $preco->preco_un_catalogo_desconto;
            $preco = $validatedData['quantidade'] < 5 ? ($preco->preco_un_catalogo * $validatedData['quantidade']) + ($carrinho[$estampa->id."_".$validatedData['cor']."_".$validatedData['tam']]['preco'] ?? 0 ) : ($preco->preco_un_catalogo_desconto * $validatedData['quantidade']) + ($carrinho[$estampa->id."_".$validatedData['cor']."_".$validatedData['tam']]['preco'] ?? 0 );
        }

        $qtd = ($carrinho[$estampa->id."_".$validatedData['cor']."_".$validatedData['tam']]['qtd'] ?? 0) + $validatedData['quantidade'];
        $carrinho[$estampa->id."_".$validatedData['cor']."_".$validatedData['tam']] = [
            'id' => $estampa->id."_".$validatedData['cor']."_".$validatedData['tam'],
            'estampa' => $estampa,
            'cor' => $cor,
            'qtd' => $qtd,
            'tam' => $validatedData['tam'],
            'preco' => $preco,
            'preco_un' => $preco_un,
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
                $preco_un = $qtd < 5 ? $preco->preco_un_proprio  : $preco->preco_un_proprio_desconto;
                $preco = $qtd < 5 ? ($preco->preco_un_proprio * $qtd) : ($preco->preco_un_proprio_desconto * $qtd);
            }
            else
            {
                $preco_un = $qtd < 5 ? $preco->preco_un_catalogo  : $preco->preco_un_catalogo_desconto;
                $preco = $qtd < 5 ? ($preco->preco_un_catalogo * $qtd) : ($preco->preco_un_catalogo_desconto * $qtd);
            }

            $carrinho[$pedido_id]['qtd'] = $qtd;
            $carrinho[$pedido_id]['preco'] = $preco;
            $carrinho[$pedido_id]['preco_un'] = $preco_un;
        }

        $request->session()->put('carrinho', $carrinho);
        return back()
            ->with('alert-msg', $msg)
            ->with('alert-type', 'success');
    }

    public function store_compra(Request $request)
    {

        $cliente = Clientes::findOrFail($request->cliente);

        if(!$cliente->nif){
            return back()
            ->with('alert-msg', 'Por favor atualize os seus dados de envio!')
            ->with('alert-type', 'danger');
        }

        $newEncomenda = new Encomendas();
        $newEncomenda->estado = "pendente";
        $newEncomenda->cliente_id = $cliente->id;
        $newEncomenda->data = date('Y-m-d');
        $newEncomenda->preco_total = $request->total_encomenda;
        $newEncomenda->notas = $request->notas;
        $newEncomenda->nif = $cliente->nif;
        $newEncomenda->endereco = $cliente->endereco;
        $newEncomenda->tipo_pagamento = $cliente->tipo_pagamento;
        $newEncomenda->ref_pagamento = $cliente->ref_pagamento;  

        $newEncomenda->save();

        $carrinho = $request->session()->get('carrinho', []);

        foreach($carrinho as $pedido)
        {
            $newTshirts = new Tshirts();

            $newTshirts->encomenda_id = $newEncomenda->id;
            $newTshirts->estampa_id = $pedido['estampa']->id;
            $newTshirts->cor_codigo = $pedido['cor']->codigo;
            $newTshirts->tamanho = $pedido['tam'];
            $newTshirts->quantidade = $pedido['qtd'];
            $newTshirts->preco_un = $pedido['preco_un'];
            $newTshirts->subtotal = $pedido['preco'];

            $newTshirts->save();
        }

        EmailController::enviar_email_encomenda_pendete($newEncomenda);
        
        $request->session()->forget('carrinho');

        return redirect()->route('home')
            ->with('alert-msg', "A sua encomenda #". $newEncomenda->id ." foi efectuada")
            ->with('alert-type', 'success');
    }
}
