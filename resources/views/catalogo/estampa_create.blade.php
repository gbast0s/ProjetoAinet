@extends('layout_admin')
@section('title', 'Nova Estampa' )
@section('titulo', 'MagicShirts - Nova Estampa' )
@section('content')
    <form method="POST" action="{{route('admin.estampas.store')}}" class="form-group" enctype="multipart/form-data">
        @csrf
        @include('catalogo.partials_estampas.estampas_create-edit')
        <div class="form-group text-right">
                <button type="submit" class="btn btn-success" name="ok">Save</button>
                <a href="{{route('admin.estampas')}}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection