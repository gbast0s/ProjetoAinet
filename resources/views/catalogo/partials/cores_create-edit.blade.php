
<div class="form-group">
    <label for="inputNome">Nome</label>
    <input type="text" class="form-control" name="nome" id="inputNome" value="{{old('nome', $cor->nome)}}" required>
    @error('nome')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
<div class="form-group">
    <label for="inputCodigo">Codigo</label>
    <input type="text" class="form-control" name="codigo" id="inputCodigo" value="{{old('codigo', $cor->codigo)}}" required>
    @error('codigo')
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