@extends('layout_admin')
@section('title','Configurar Preços' )
@section('titulo','MagicShirts - Configurar Preços' )
@section('content')
    <form method="POST" action="{{route('admin.precos.update', ['precos' => $precos]) }}" class="form-group" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="inputPreco">Preço Estampa</label>
            <input type="text" class="form-control" name="preco_un_catalogo" id="inputPreco" value="{{old('preco_un_catalogo', $precos->preco_un_catalogo)}}" required>
            @error('preco_un_catalogo')
                <div class="small text-danger">{{$message}}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="inputPrecoProprio">Preço Estampa Privada</label>
            <input type="text" class="form-control" name="preco_un_proprio" id="inputPrecoProprio" value="{{old('preco_un_proprio', $precos->preco_un_proprio)}}" required>
            @error('preco_un_proprio')
                <div class="small text-danger">{{$message}}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="inputPrecoDesconto">Preço de Estampa com Desconto</label>
            <input type="text" class="form-control" name="preco_un_catalogo_desconto" id="inputPrecoDesconto" value="{{old('preco_un_catalogo_desconto', $precos->preco_un_catalogo_desconto)}}" required>
            @error('preco_un_catalogo_desconto')
                <div class="small text-danger">{{$message}}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="inputPrecoPrivadoDesconto">Preço Estampa Privada com Desconto</label>
            <input type="text" class="form-control" name="preco_un_proprio_desconto" id="inputPrecoPrivadoDesconto" value="{{old('preco_un_proprio_desconto', $precos->preco_un_proprio_desconto)}}" required>
            @error('preco_un_proprio_desconto')
                <div class="small text-danger">{{$message}}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="inputQuantidade">Quantidade Para Desconto</label>
            <input type="text" class="form-control" name="quantidade" id="inputQuantidade" value="{{old('quantidade', $precos->quantidade_desconto)}}" required>
            @error('quantidade')
                <div class="small text-danger">{{$message}}</div>
            @enderror
        </div>
        <div class="form-group text-right">
            <button type="submit" class="btn btn-success" name="ok">Save</button>
            <a href="{{route('admin.precos') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection