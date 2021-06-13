@extends('layout_admin')
@section('title', 'Nova Categoria' )
@section('titulo', 'MagicShirts - Nova Cor' )
@section('content')
    <form method="POST" action="{{ route('admin.cores.store') }}" class="form-group" enctype="multipart/form-data">
        @csrf
        @include('catalogo.partials.cores_create-edit')
        <div class="form-group text-right">
                <button type="submit" class="btn btn-success" name="ok">Save</button>
                <a href="{{route('admin.cores')}}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection