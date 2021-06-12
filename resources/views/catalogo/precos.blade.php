@extends('layout_admin')
@section('titulo', 'MagicShirts - Preços' )
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Preços</h1>
</div>
<table class="table">
    <thead>
        <tr>
            <th>Preço Estampa</th>
            <th>Preço Estampa Privada</th>
            <th>Preço de Estampa com Desconto</th>
            <th>Preço Estampa Privada com Desconto</th>
            <th>Quantidade Para Desconto</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{$precos->preco_un_catalogo}} €</td>
            <td>{{$precos->preco_un_proprio}} €</td>
            <td>{{$precos->preco_un_catalogo_desconto}} €</td>
            <td>{{$precos->preco_un_proprio_desconto}} €</td>
            <td>{{$precos->quantidade_desconto}}</td>
            <td><a href="{{ route('admin.precos.edit', ['precos' => $precos]) }}" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Configurar</a></td>
        </tr>
    </tbody>
</table>
@endsection

