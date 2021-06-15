@extends('layout_admin')
@section('titulo', 'MagicShirts - Encomendas' )
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Encomendas de: {{$cliente->user->name}}</h1>
</div>
<div class="row mb-3">
    <div class="col-9">
        <form method="GET" action="{{route('admin.clientes.encomendas', $cliente)}}" class="form-group">
            <div class="input-group">
            <select class="custom-select" name="status" id="inputStatus" aria-label="Status">
                <option value="" {{'' == old('status', $selectedStatus) ? 'selected' : ''}}>Todos as encomendas</option>
                <option value="pendente" {{'pendente' == old('status', $selectedStatus) ? 'selected' : ''}}>Encomendas Pendentes</option>
                <option value="paga" {{'paga' == old('status', $selectedStatus) ? 'selected' : ''}}>Encomendas Pagas</option>
                <option value="fechada" {{'fechada' == old('status', $selectedStatus) ? 'selected' : ''}}>Encomendas Fechadas</option>
                <option value="anulada" {{'anulada' == old('status', $selectedStatus) ? 'selected' : ''}}>Encomendas Anuladas</option>
            </select>
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">Filtrar</button>
            </div>
            </div>
        </form>
        <form method="GET" action="{{route('admin.clientes.encomendas', $cliente)}}" class="form-group">
            <div class="input-group mb-3">
                <input type="text" name="data" class="form-control" value="{{old('data', $data)}}" placeholder="Data Encomenda" aria-label="Data Encomenda" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Filtrar</button>
                </div>
            </div>
        </form>
    </div>
</div>
    <table class="table">
        <thead>
            <tr>
                <th>Estado</th>
                <th>Data</th>
                <th>Preço Total</th>
                <th>Notas</th>
                <th>Endereço</th>
                <th>Tipo Pagamento</th>
                <th>Referencia</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($encomendas as $encomenda)
                <tr>
                    <td>{{$encomenda->estado}}</td>
                    <td>{{$encomenda->data}}</td>
                    <td>{{$encomenda->preco_total}} €</td>
                    <td>{{$encomenda->notas}}</td>
                    <td>{{$encomenda->endereco}}</td>
                    <td>{{$encomenda->tipo_pagamento}}</td>
                    <td>{{$encomenda->ref_pagamento}}</td>
                    @if($encomenda->recibo_url)
                        <td>
                            <form action="" method="GET">
                                <input type="button" class="btn btn-outline-dark" value="Fatura">
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="form-group text-right">
            <a href="{{route('admin.clientes') }}" class="btn btn-info">Voltar atrás</a>
    </div>
    {{ $encomendas->withQueryString()->links() }}
@endsection

