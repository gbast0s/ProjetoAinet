@extends('layout_admin')
@section('title','Alterar Cor' )
@section('titulo','MagicShirts - Alterar Cor' )
@section('content')
    <form method="POST" action="{{route('admin.cores.update', ['cor' => $cor]) }}" class="form-group" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('catalogo.partials.cores_create-edit')
        <div class="form-group text-right">
            <button type="submit" class="btn btn-success" name="ok">Save</button>
            <a href="{{route('admin.cores') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection