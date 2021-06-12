@extends('layout_admin')
@section('titulo', 'MagicShirts - Estampas' )
@section('content')
<div class="row mb-3">
    <div class="col-3">
        <a href="{{route('admin.estampas.create')}}" class="btn btn-success" role="button" aria-pressed="true">Nova Estampa</a>
    </div>
    <div class="col-9">
        <form method="GET" action="{{ route('admin.estampas') }}" class="form-group">
            <div class="input-group">
            <select class="custom-select" name="categoria" id="inputCategoria" aria-label="Categoria">
                <option value="" {{'' == old('categoria', $selectedCategoria) ? 'selected' : ''}}>Todas as categorias</option>
                @foreach($categorias as $categoria)
                    <option value="{{$categoria->id}}" {{ $categoria->id == old('categoria', $selectedCategoria) ? 'selected' : ''}}>{{$categoria->nome}}</option>
                @endforeach
            </select>
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
                <th></th>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Descrição</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($estampas as $estampa)
                <tr>
                    <td>
                        <img src="{{$estampa->imagem_url ? asset('storage/estampas/' . $estampa->imagem_url) : asset('img/default_img.png') }}" alt="Foto do Cliente"  class="img-profile" style="width:40px;height:40px">
                    </td>
                    <td>{{$estampa->nome}}</td>
                    <td>
                    @if($estampa->categoria)
                        {{$estampa->categoria->nome}}
                    @else
                        Sem Categoria
                    @endif
                    </td>
                    <td>{{$estampa->descricao}}</td>
                    <td><a href="{{route('admin.estampas.edit', ['estampa' => $estampa])}}" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Alterar</a></td>
                    <td>
                        <form action="{{route('admin.estampas.destroy', ['estampa' => $estampa])}}" method="POST">
                            @csrf
                            @method("DELETE")
                            <input type="submit" class="btn btn-danger btn-sm" value="Apagar">
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $estampas->withQueryString()->links() }}
@endsection