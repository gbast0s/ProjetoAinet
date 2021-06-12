@extends('layout_admin')
@section('title','Alterar Staff' )
@section('titulo','MagicShirts - Alterar Staff' )
@section('content')
    <form method="POST" action="{{route('admin.staff.update', ['staff' => $staff]) }}" class="form-group" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('partials.staff_create-edit')
        @isset($staff->foto_url)
            <div class="form-group">
                <img src="{{$staff->foto_url ? asset('storage/fotos/' . $staff->foto_url) : asset('img/default_img.png') }}"
                     alt="Foto do docente"  class="img-profile"
                     style="max-width:100%">
            </div>
        @endisset
        <div class="form-group text-right">
            @isset($staff->foto_url)
                <button type="submit" class="btn btn-danger" name="deletefoto" form="form_delete_photo">Apagar Foto</button>
            @endisset
            <button type="submit" class="btn btn-success" name="ok">Save</button>
            <a href="{{route('admin.staff') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
    <form id="form_delete_photo" action="{{route('admin.staff.foto.destroy', ['staff' => $staff])}}" method="POST">
        @csrf
        @method('DELETE')
    </form>
@endsection