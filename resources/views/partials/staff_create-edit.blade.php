<div class="form-group">
    <label for="inputNome">Nome</label>
    <input type="text" class="form-control" name="name" id="inputNome" value="{{old('name', $staff->name)}}" required>
    @error('name')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
<div class="form-group">
    <label for="inputEmail">Email</label>
    <input type="email" class="form-control" name="email" id="inputEmail" value="{{old('email', $staff->email)}}" required>
    @error('email')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
<div class="form-group">
    <div>Tipo</div>
    <div class="form-check form-check-inline">
        <input type="radio" class="form-check-input" id="inputAdmin" name="tipo" value="A" {{old('tipo',  $staff->tipo) == 'A' ? 'checked' : ''}} required>
        <label class="form-check-label" for="inputAdmin"> Admin </label>
        <input type="radio" class="form-check-input ml-4" id="inputFuncionario" name="tipo" value="F" {{old('tipo',  $staff->tipo) == 'F' ? 'checked' : ''}}>
        <label class="form-check-label" for="inputFuncionario"> Funcionário </label>
    </div>
    @error('tipo')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
<div class="form-group">
            <label for="inputPassword">Password</label>
            <input type="password" class="form-control" name="password" id="inputPassword" value="" required>
            @error('password')
                <div class="small text-danger">{{$message}}</div>
            @enderror
</div>
<div class="form-group">
    <label for="inputFoto">Upload da foto</label>
    <input type="file" class="form-control" name="foto" id="inputFoto">
    @error('foto')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>