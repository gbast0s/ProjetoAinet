@extends('layout_admin')
@section('title', 'Novo Staff' )
@section('titulo', 'MagicShirts - Novo Staff' )
@section('content')
    <form method="POST" action="{{route('admin.staff.store')}}" class="form-group" enctype="multipart/form-data">
        @csrf
        @include('partials.staff_create-edit')
        <div class="form-group text-right">
                <button type="submit" class="btn btn-success" name="ok">Save</button>
                <a href="{{route('admin.staff')}}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection