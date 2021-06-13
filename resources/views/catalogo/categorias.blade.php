@extends('layout_admin')
@section('titulo', 'MagicShirts - Categorias' )
@section('content')
<div class="row mb-3">
    <div class="col-3">
        <a href="{{ route('admin.categorias.create') }}" class="btn btn-success" role="button" aria-pressed="true">Nova Categoria</a>
    </div>
</div>
<table class="table">
    <thead>
        <tr>
            <th>Nome da Categoria</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($categorias as $categoria)
            <tr>
                <td>{{$categoria->nome}}</td>
                <td><a href="{{ route('admin.categorias.edit', ['categoria' => $categoria]) }}" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Alterar</a></td>
                <td>
                        <form action="{{route('admin.categorias.destroy', ['categoria' => $categoria])}}" method="POST">
                            @csrf
                            @method("DELETE")
                            <input type="submit" class="btn btn-danger btn-sm" value="Apagar">
                        </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $categorias->withQueryString()->links() }}
@endsection

