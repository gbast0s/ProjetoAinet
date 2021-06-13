@extends('layout_admin')
@section('title', 'Nova Categoria' )
@section('titulo', 'MagicShirts - Nova Categoria' )
@section('content')
    <form method="POST" action="{{route('admin.categorias.store')}}" class="form-group" enctype="multipart/form-data">
        @csrf
        @include('catalogo.partials.categoria_create-edit')
        <div class="form-group text-right">
                <button type="submit" class="btn btn-success" name="ok">Save</button>
                <a href="{{route('admin.categorias')}}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection