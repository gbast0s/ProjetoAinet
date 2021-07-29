@extends('layout_admin')
@section('titulo', 'MagicShirts - Clientes' )
@section('content')
<div class="row mb-3">
    <div class="col-9">
        <form method="GET" action="{{route('admin.clientes')}}" class="form-group">
            <div class="input-group">
            <select class="custom-select" name="status" id="inputStatus" aria-label="Status">
                <option value="" {{'' == old('status', $selectedStatus) ? 'selected' : ''}}>Todos os clientes</option>
                <option value="1" {{'1' == old('status', $selectedStatus) ? 'selected' : ''}}>Clientes Bloqueados</option>
                <option value="0" {{'0' == old('status', $selectedStatus) ? 'selected' : ''}}>Clientes Desbloqueados</option>
            </select>
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">Filtrar</button>
            </div>
            </div>
        </form>
        <form method="GET" action="{{route('admin.clientes')}}" class="form-group">
            <div class="input-group mb-3">
                <input type="text" name="id" class="form-control" value="{{old('id', $id)}}" placeholder="ID Cliente" aria-label="ID Cliente" aria-describedby="basic-addon2">
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
                <th>ID</th>
                <th></th>
                <th>Nome</th>
                <th>Email</th>
                <th>Nif</th>
                <th>Bloqueado</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clientes as $cliente)
                <tr>
                    <td>{{$cliente->user->id}}</td>
                    <td>
                        <img src="{{$cliente->user->foto_url ? asset('storage/fotos/' . $cliente->user->foto_url) : asset('img/default_img.png') }}" alt="Foto do Cliente"  class="img-profile rounded-circle" style="width:40px;height:40px">
                    </td>
                    <td>{{$cliente->user->name}}</td>
                    <td>{{$cliente->user->email}}</td>
                    <td>{{$cliente->nif}}</td>
                    @if($cliente->user->bloqueado)
                        <td>Sim</td>
                    @else
                        <td>Não</td>
                    @endif
                    <td>
                    <td><a href="{{ route('admin.clientes.encomendas', $cliente) }}" class="btn btn-outline-secondary" role="button" aria-pressed="true">Encomendas</a></td>
                    @if($cliente->user->bloqueado)
                    <form method="POST" action="{{ route('admin.clientes.unlock', ['id' => $cliente->id, 'block' => '0']) }}" class="input" enctype="multipart/form-data">
                        @csrf
                        <td><button type="submit" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Desbloquear</button></td>
                    </form>
                    @else
                    <form method="POST" action="{{ route('admin.clientes.unlock', ['id' => $cliente->id, 'block' => '1']) }}" class="input" enctype="multipart/form-data">
                        @csrf
                        <td><button type="submit" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Bloquear</button></td>
                    </form>
                    @endif
                    </td>
                    <td>
                        <form action="{{route('admin.clientes.destroy', ['cliente' => $cliente])}}" method="POST">
                            @csrf
                            @method("DELETE")
                            <input type="submit" class="btn btn-danger btn-sm" value="Apagar">
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $clientes->withQueryString()->links() }}
@endsection

