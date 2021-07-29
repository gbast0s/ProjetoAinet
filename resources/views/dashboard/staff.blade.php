@extends('layout_admin')
@section('titulo', 'MagicShirts - Staffs' )
@section('content')
<div class="row mb-3">
    <div class="col-3">
        <a href="{{route('admin.staff.create')}}" class="btn btn-success" role="button" aria-pressed="true">Novo Staff</a>
    </div>
    <div class="col-9">
        <form method="GET" action="{{route('admin.staff')}}" class="form-group">
            <div class="input-group">
            <select class="custom-select" name="status" id="inputStatus" aria-label="Status">
                <option value="" {{'' == old('status', $selectedStatus) ? 'selected' : ''}}>Todos os Staffs</option>
                <option value="1" {{'1' == old('status', $selectedStatus) ? 'selected' : ''}}>Staffs Bloqueados</option>
                <option value="0" {{'0' == old('status', $selectedStatus) ? 'selected' : ''}}>Staffs Desbloqueados</option>
                <option value="A" {{'A' == old('status', $selectedStatus) ? 'selected' : ''}}>Staffs Administradores</option>
                <option value="F" {{'F' == old('status', $selectedStatus) ? 'selected' : ''}}>Staffs Funcionários</option>
            </select>
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">Filtrar</button>
            </div>
            </div>
        </form>
    </div>
</div>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th></th>
                <th>Nome</th>
                <th>Email</th>
                <th>Tipo</th>
                <th>Bloqueado</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($staffs as $staff)
                <tr>
                    <td>{{$staff->id}}</td>
                    <td>
                        <img src="{{$staff->foto_url ? asset('storage/fotos/' . $staff->foto_url) : asset('img/default_img.png') }}" alt="Foto do Cliente"  class="img-profile rounded-circle" style="width:40px;height:40px">
                    </td>
                    <td>{{$staff->name}}</td>
                    <td>{{$staff->email}}</td>
                    <td>{{$staff->tipo}}</td>
                    @if($staff->bloqueado)
                        <td>Sim</td>
                    @else
                        <td>Não</td>
                    @endif
                    <td></td>
                    @if($staff->bloqueado)
                    <form method="POST" action="{{ route('admin.staff.unlock', ['id' => $staff->id, 'block' => '0']) }}" class="input" enctype="multipart/form-data">
                        @csrf
                        <td><button type="submit" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Desbloquear</button></td>
                    </form>
                    @else
                    <form method="POST" action="{{ route('admin.staff.unlock', ['id' => $staff->id, 'block' => '1']) }}" class="input" enctype="multipart/form-data">
                        @csrf
                        <td><button type="submit" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Bloquear</button></td>
                    </form>
                    @endif
                    <td><a href="{{route('admin.staff.edit', ['staff' => $staff])}}" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Alterar</a></td>
                    <td>
                        <form action="{{route('admin.staff.destroy', ['staff' => $staff])}}" method="POST">
                            @csrf
                            @method("DELETE")
                            <input type="submit" class="btn btn-danger btn-sm" value="Apagar">
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $staffs->withQueryString()->links() }}
@endsection

