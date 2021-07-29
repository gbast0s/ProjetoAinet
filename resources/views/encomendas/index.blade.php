@extends('layout_admin')
@section('titulo', 'MagicShirts - Encomendas' )
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"></h1>
</div>
<div class="row mb-3">
    <div class="col-9">
        <form method="GET" action="" class="form-group">
            <div class="input-group">
                <select class="custom-select" name="status" id="inputStatus" aria-label="Status">
                    <option value="" {{'' == old('status', $selectedStatus) ? 'selected' : ''}}>Todos as encomendas</option>
                    <option value="pendente" {{'pendente' == old('status', $selectedStatus) ? 'selected' : ''}}>Encomendas Pendentes</option>
                    <option value="paga" {{'paga' == old('status', $selectedStatus) ? 'selected' : ''}}>Encomendas Pagas</option>
                    @if(Auth::user()->isAdmin())
                        <option value="fechada" {{'fechada' == old('status', $selectedStatus) ? 'selected' : ''}}>Encomendas Fechadas</option>
                        <option value="anulada" {{'anulada' == old('status', $selectedStatus) ? 'selected' : ''}}>Encomendas Anuladas</option>
                    @endif
                </select>
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Filtrar</button>
                </div>
            </div>
            <div class="data_encomendas">
                <div class="input-group mb-3">
                    <input type="text" name="data" class="form-control" value="{{old('data', $data)}}" placeholder="Data Encomenda" aria-label="Data Encomenda" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Filtrar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
    <table class="table">
        <thead>
            <tr>
                <th>Cliente ID</th>
                <th>Estado</th>
                <th>Data</th>
                <th>Preço Total</th>
                <th>NIF</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($encomendas as $encomenda)
                <tr>
                    <td>{{$encomenda->cliente_id}}</td>
                    <td>{{strtoupper($encomenda->estado)}}</td>
                    <td>{{$encomenda->data}}</td>
                    <td>{{$encomenda->preco_total}} €</td>
                    <td>{{$encomenda->nif}}</td>
                    <td><a href="{{ route('admin.encomenda.detalhes_encomenda', $encomenda) }}" class="btn btn-outline-secondary" role="button" aria-pressed="true">Detalhes</a></td>
                    @if($encomenda->estado == "pendente")
                        <form method="POST" action="{{route('admin.encomenda.mudar.estado', ['id' => $encomenda->id, 'estado' => 'paga'])}}" class="input" enctype="multipart/form-data">
                            @csrf
                            <td><button type="submit" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Pagar</button></td>
                        </form>
                    @elseif($encomenda->estado == "paga")
                    <form method="POST" action="{{route('admin.encomenda.mudar.estado', ['id' => $encomenda->id, 'estado' => 'fechada'])}}" class="input" enctype="multipart/form-data">
                        @csrf
                        <td><button type="submit" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Fechar</button></td>
                    </form>
                    @endif
                    @if(Auth::user()->isAdmin() && $encomenda->estado != 'fechada' && $encomenda->estado != 'anulada')
                        <form method="POST" action="{{route('admin.encomenda.mudar.estado', ['id' => $encomenda->id, 'estado' => 'anulada'])}}" class="input" enctype="multipart/form-data">
                            @csrf
                            <td><button type="submit" class="btn btn-danger btn-sm" role="button" aria-pressed="true">Anular</button></td>
                        </form>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- <div class="form-group text-right">
            <a href="{{route('admin.clientes') }}" class="btn btn-info">Voltar atrás</a>
    </div> -->
    {{ $encomendas->withQueryString()->links() }}
@endsection

