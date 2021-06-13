<div class="form-group">
    <label for="inputNome">Nome</label>
    <input type="text" class="form-control" name="nome" id="inputNome" value="{{old('nome', $estampa->nome)}}" required>
    @error('nome')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
<div class="form-group">
    <label for="inputCategoria">Categoria</label>
    <select class="custom-select" name="categoria" id="inputCategoria" aria-label="Categoria">
        <option value="" {{'' == old('categoria', $selectedCategoria) ? 'selected' : ''}}>Sem Categoria</option>
        @foreach($categorias as $categoria)
            <option value="{{$categoria->id}}" {{ $categoria->id == old('categoria', $selectedCategoria) ? 'selected' : ''}}>{{$categoria->nome}}</option>
        @endforeach
    </select>
    @error('categoria')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
<div class="form-group">
    <label for="inputNome">Descricao</label>
    <input type="text" class="form-control" name="descricao" id="inputDescricao" value="{{old('descricao', $estampa->descricao)}}">
    @error('descricao')
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