@extends('layout_admin')
@section('title','Alterar Password' )
@section('titulo','MagicShirts - Alterar Password' )
@section('content')
    <form method="POST" action="{{ route('admin.pass.update', $staff) }}" class="form-group" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="inputPassword">Password</label>
            <input type="password" class="form-control" name="password" id="inputPassword" value="" required>
            @error('password')
                <div class="small text-danger">{{$message}}</div>
            @enderror
        </div>
        <div class="form-group text-right">
            <button type="submit" class="btn btn-success" name="ok">Save</button>
            <a href="{{route('admin.encomendas') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection