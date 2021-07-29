@extends('layout_admin')
@section('title','Alterar Estampa' )
@section('titulo','MagicShirts - Alterar Estampa' )
@section('content')
    <form method="POST" action="{{route('admin.estampas.update', ['estampa' => $estampa]) }}" class="form-group" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('catalogo.partials.estampas_create-edit')
        @isset($estampa->imagem_url)
            <div class="form-group">
                <img src="{{$estampa->imagem_url ? asset('storage/estampas/' . $estampa->imagem_url) : asset('img/default_img.png') }}"
                     alt="Foto do docente"  class="img-profile"
                     style="max-width:100%">
            </div>
        @endisset
        <div class="form-group text-right">
            <button type="submit" class="btn btn-success" name="ok">Save</button>
            <a href="{{route('admin.estampas') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection