@extends('layout_admin')
@section('titulo', 'MagicShirts - Encomendas' )
@section('content')
    <div class="detalhes-encomendas">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detalhes da encomenda #{{ $encomenda->id }}</h1>
        </div>
        @if($encomenda->notas)
            <h5 class="mb-0 text-gray-800">Notas Encomenda: </h5><a>{{$encomenda->notas}}</a>
        @else
            <h5 class="mb-0 text-gray-800">Notas Encomenda:</h5><a>Nada a visar</a>
        @endif
        <div class="dados-encomendas-1">
            <div class="dados-cliente-encomendas">
                <h3>Detalhes de cliente</h3>
                @if($encomenda->cliente)
                    <a>Nome de cliente:</a><a>{{ $encomenda->cliente->user->name }}</a>
                @else
                    <a>Nome de cliente:</a><a>Inacessivel</a>
                @endif
                <a>Endereço:</a><a>{{ $encomenda->endereco }}</a>
            </div>
            <div class="dados-pagamento-encomendas">
                <h3>Detalhes de pagamento</h3>
                <a>Tipo Pagamento:</a><a>{{$encomenda->tipo_pagamento}}</a>
                <a>Ref Pagamento:</a><a>{{$encomenda->ref_pagamento}}</a>
                <a>Custo total:</a><a>{{$encomenda->preco_total}} €</a>
            </div>
        </div>
        <div class="lista-encomendas-feitas">
            <h3>Produtos encomendados</h3>
            <div class="produtos-tabela">
                @foreach($tshirts as $tshirt)
                    <div class="produto-unitario">
                        <a>Imagem da estampa:</a>
                        @if($tshirt->estampa && $tshirt->estampa->cliente_id)
                            <a href="{{ route('admin.estampa.privada', $tshirt) }}" target="_blank"><img src="{{ route('admin.estampa.privada', $tshirt) }}" alt="" /></a>
                        @elseif($tshirt->estampa)
                            <a href=" {{ asset('storage/estampas/' . $tshirt->estampa->imagem_url) }}" target="_blank"><img src="{{$tshirt->estampa->imagem_url ? asset('storage/estampas/' . $tshirt->estampa->imagem_url) : asset('img/default_img.png') }}"  alt=""/></a>
                        @else
                            <a>Inacessivel</a>
                        @endif
                        <a>Tamanho:</a><a>{{$tshirt->tamanho}}</a>
                        @if($tshirt->cor)
                            <a>Cor:</a><a>{{$tshirt->cor->nome}}</a>
                        @else
                            <a>Cor:</a><a>Inacessivel</a>
                        @endif
                        <a>Quantidade:</a><a>{{$tshirt->quantidade}}</a>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="botoes-detalhes">
            @if(Auth::user()->tipo == 'A' && $encomenda->recibo_url)
                <div class="form-group text-right">
                    <a href="{{route('fatura.mostrar', $encomenda->recibo_url) }}" class="btn btn-outline-dark" target="_blank">Fatura</a>
                </div>
            @endif
            <div class="form-group text-right">
                <a href="{{route('admin.encomendas') }}" class="btn btn-info">Voltar atrás</a>
            </div>
        </div>
    </div>
@endsection
