@extends('layout_admin')
@section('titulo', 'MagicShirts - Cores' )
@section('content')
<div class="row mb-3">
    <div class="col-3">
        <a href="" class="btn btn-success" role="button" aria-pressed="true">Nova Cor</a>
    </div>
</div>
<table class="table">
    <thead>
        <tr>
            <td></td>
            <th>Codigo da Cor</th>
            <th>Nome da Cor</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($cores as $cor)
            <tr>
                <td><div class="colors" style="background: #{{ $cor->codigo }}"></div></td>
                <td>#{{$cor->codigo}}</td>
                <td>{{$cor->nome}}</td>
                <td><a href="" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Alterar</a></td>
                <td>
                    <form action="" method="POST">
                        @csrf
                        @method("DELETE")
                        <input type="submit" class="btn btn-danger btn-sm" value="Apagar">
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $cores->withQueryString()->links() }}
@endsection

