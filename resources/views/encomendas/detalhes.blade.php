@extends('layout_admin')
@section('titulo', 'MagicShirts - Encomendas' )
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"></h1>
</div>
<div class="row mb-3">
    <div class="col-9">
    </div>
</div>
    <label>Nome Cliente: {{$encomenda->cliente->user->name}}<label>
    <label>Endereço: {{$encomenda->endereco}}<label>
    <label>Tipo Pagamento: {{$encomenda->tipo_pagamento}}<label>
    <label>Ref Pagamento: {{$encomenda->ref_pagamento}}<label>
    <label>Custo total: {{$encomenda->preco_total}} €<label>
    <label>Endereço: {{$encomenda->endereco}}<label>

    @foreach($tshirts as $tshirt) 
        @if($tshirt->estampa && $tshirt->estampa->cliente_id)
            <label>Tamanho: {{$tshirt->tamanho}}<label>
            @if($tshirt->cor)
                <label>Cor: {{$tshirt->cor->nome}}<label>
            @endif
            <label>Quantidade: {{$tshirt->quantidade}}<label>
            <img src="{{ route('admin.estampa.privada', $tshirt) }}" class="estampa_tshirt"  alt="" />
        @elseif($tshirt->estampa)
            <label>Tamanho: {{$tshirt->tamanho}}<label>
            @if($tshirt->cor)
                <label>Cor: {{$tshirt->cor->nome}}<label>
            @endif
            <label>Quantidade: {{$tshirt->quantidade}}<label>
            <img src="{{$tshirt->estampa->imagem_url ? asset('storage/estampas/' . $tshirt->estampa->imagem_url) : asset('img/default_img.png') }}" class="estampa_tshirt"  alt=""/>
        @endif
    @endforeach
    <div class="form-group text-right">
            <a href="{{route('admin.encomendas') }}" class="btn btn-info">Voltar atrás</a>
    </div>


    <div class="form-group text-right">
            <a href="{{route('admin.encomendas') }}" class="btn btn-outline-dark">Fatura</a>
    </div>
        

@endsection