@extends('partials.header_footer')
@section('titulo', 'MagicShirts - Checkout')
@section('content')

<section id="cart_items">
    <div class="container">
        <div>
            <h2 class="heading">Detalhes de envio</h2>
        </div>
        @if ($cliente->nif)
            <div class="config-atuais">
                <h3 class="titulo">Dados atuais da conta</h3>
                <div class="g1">
                    <div class="g1-1">
                        <div class="caixa-dados">
                            <div class="caixa-dados-esq">
                                <p>NIF do cliente:</p>
                            </div>
                            <div class="caixa-dados-dir">
                                <p>{{$cliente->nif}}</p>
                            </div>
                        </div>
                        <div class="caixa-dados">
                            <div class="caixa-dados-esq">
                                <p>Endereço:</p>
                            </div>
                            <div class="caixa-dados-dir">
                                <p>{{$cliente->endereco}}</p>
                            </div>
                        </div>
                        <div class="caixa-dados">
                            <div class="caixa-dados-esq">
                                <p>Tipo de pagamento:</p>
                            </div>
                            <div class="caixa-dados-dir">
                                <p>{{ $cliente->tipo_pagamento }}</p>
                            </div>
                        </div>
                        <div class="caixa-dados">
                            <div class="caixa-dados-esq">
                                <p>Referência de pagamento:</p>
                            </div>
                            <div class="caixa-dados-dir">
                                <p>{{ $cliente->ref_pagamento }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="g1-2">
                        <div class="caixa-dados-notas">
                            <p>Notas:</p>
                            <textarea form="formCheckout" name="notas" type="text" cols="50"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="botoes-carrinho3">
                <a class="btn btn-default update" href="{{ route('usuario.perfil') }}">Atualizar os dados</a>
            </div>
        @else
            <div class="botoes-carrinho3">
                <p>Os dados não estão atualizados.</p>
                <a class="btn btn-default update" href="{{ route('usuario.perfil') }}">Atualizar os dados</a>
            </div>
        @endif

        <div class="review-payment">
            <h2>Revisão e Pagamento</h2>
        </div>
        <div class="tabela-compras-div">
            @if ($carrinho)
                <table class="tabela-compras">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Nome</th>
                            <th>Tamanho</th>
                            <th>Cor</th>
                            <th>Quantidade</th>
                            <th>Total</th>
                            <th>Remover</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($carrinho as $pedido)
                        <tr>
                            <td class="estampa-carrinho">
                                <img class="estampa-carrinho" src="/storage/tshirt_base/{{$pedido['cor']->codigo}}.jpg" alt="" />
                                @if($pedido['estampa']->cliente_id)
                                    <div class="overlay">
                                        <img src="{{ route('catalogo.estampa.privada', $pedido['estampa']) }}" alt="" />
                                    </div>
                                @else
                                    <div class="overlay">
                                        <img src="{{$pedido['estampa']->imagem_url ? asset('storage/estampas/' . $pedido['estampa']->imagem_url) : asset('img/default_img.png') }}" alt=""/>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <h4>{{$pedido['estampa']->nome}}</h4>
                            </td>
                            <td>
                                <p>{{$pedido['tam']}}</p>
                            </td>
                            <td>
                                <p>{{$pedido['cor']->nome}}</p>
                            </td>
                            <td>
                                <div class="quantidade">
                                    <form action="{{ route('carrinho.update_pedido', ['pedido_id' => $pedido['id']]) }}" method="POST">
                                        @csrf
                                        @method('put')
                                        <input type="hidden" name="quantidade" value="-1">
                                        <button type="submit" class="o" onclick="decrementar()"> - </button>
                                    </form>
                                    <label>{{$pedido['qtd']}}</label>
                                    <form action="{{ route('carrinho.update_pedido', ['pedido_id' => $pedido['id']]) }}" method="POST">
                                        @csrf
                                        @method('put')
                                        <input type="hidden" name="quantidade" value="1">
                                        <button type="submit" class="o" onclick="incrementar()"> + </button>

                                    </form>
                                </div>
                            </td>
                            <td>
                                <p>{{$pedido['preco']}} €</p>
                            </td>
                            <td class="eliminar-produto">
                                <form action="{{ route('carrinho.destroy_pedido', ['pedido_id' => $pedido['id']]) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit"><i class="fa fa-times"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="nao-existe-produto">
                    <p>Não existem produtos no carrinho.</p>
                    <a>Clique </a><a href="{{ route('catalogo') }}">aqui</a><a> para começar a comprar.</a>
                </div>
            @endif
        </div>
        @if ($carrinho)
            <section class="do_action">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                        </div>
                        <div class="col-sm-6">
                            <div class="total_area">
                                <ul>
                                    <li>Sub Total Carrinho <span>{{ $custoTotal }} €</span></li>
                                    <li>Custo de Envio <span>Grátis</span></li>
                                    <li>Total <span>{{ $custoTotal }} €</span></li>
                                </ul>
                                <div class="botoes-carrinho2">
                                    <form action="{{ route('carrinho.destroy') }}" method="POST">
                                        @csrf
                                        @method("DELETE")
                                        <button class="btn btn-default update" type="submit" value="">Apagar carrinho</button>
                                    </form>
                                    <a class="btn btn-default update" href="{{ route('usuario.checkout') }}">Atualizar</a>
                                    <form action="{{ route('usuario.carrinho.store_compra', ['cliente' => $cliente, 'total_encomenda' => $custoTotal] ) }}" id="formCheckout" method="POST">
                                        @csrf
                                        <button class="btn btn-default update" type="submit" value="" {{ $cliente->nif ? '' : 'disabled' }}>Confirmar carrinho</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section><!--/#do_action-->
        @endif
    </div>
</section> <!--/#cart_items-->
@endsection
