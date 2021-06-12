<div class="form-group">
    <label for="inputNome">Nome</label>
    <input type="text" class="form-control" name="name" id="inputNome" value="{{old('name', $categoria->nome)}}" required>
    @error('name')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
