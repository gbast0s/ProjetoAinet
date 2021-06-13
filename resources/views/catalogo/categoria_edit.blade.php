@extends('layout_admin')
@section('title','Alterar Categoria' )
@section('titulo','MagicShirts - Alterar Categoria' )
@section('content')
    <form method="POST" action="{{route('admin.categorias.update', ['categoria' => $categoria]) }}" class="form-group" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('catalogo.partials.categoria_create-edit')
        <div class="form-group text-right">
            <button type="submit" class="btn btn-success" name="ok">Save</button>
            <a href="{{route('admin.categorias') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection