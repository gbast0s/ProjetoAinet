@extends('partials.header_footer')
@section('titulo', 'MagicShirts - Estampa Personalizada')
@section('content')
<body>
    <div class="custom">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="top">
                        <h2>Estampagem personalizada</h2>
                        <h4>Aqui, podes criar a tua própria t-shirt.
                            Basta apenas associar a tua conta e enviar a tua imagem, que o resto nós tratamos.</h4>
                    </div>
                    <div class="barra">
						<div class="mainmenu">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="{{ route('usuario.estampa_personalizada.id',  '#ver-estampagens')}}">As minhas Estampas</a></li>
								<li><a href="#adicionar-estampagens">Adicionar nova Estampa</a></li>
							</ul>
						</div>
					</div>
                    <div class="list">
                        <h3 id="ver-estampagens" class="titulo">As minhas Estampas</h3>
                        <div class="group-1">
                            <a>Aqui, podes observar todas as tuas estampas.</a>
                            <p>Cliente: {{Auth::user()->name}}</p>
                            <p>Lista das estampas adicionadas:</p>
                            @if($estampasPrivada)
                                <div class="imagens-privadas">
                                    @foreach($estampasPrivada as $estampaP)
                                        <table>
                                            <tr>
                                                <td>
                                                    <a href="{{ route('catalogo.estampa', $estampaP) }}"><img src="{{ route('catalogo.estampa.privada', $estampaP) }}" alt=""/></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="nome-imagem-privada"><a>{{$estampaP->nome}}</a></td>
                                            </tr>
                                            <tr>
                                                <form action="{{route('catalogo.estampa.destroy', ['estampa' => $estampaP])}}" method="POST">
                                                    @csrf
                                                    @method("DELETE")
                                                    <td class="botaoApagar"><input type="submit" class="btn btn-danger btn-sm" value="Apagar"></td>
                                                </form>
                                            </tr>
                                        </table>
                                    @endforeach
                                </div>
                            @else
                                <p>Não tem estampas privadas</p>
                            @endif
                        </div>
                    </div>
                    @if($estampasPrivada)
                        {{ $estampasPrivada->withQueryString()->links() }}
                    @endif
                    <div class="adicionar">
                        <h3 id="adicionar-estampagens" class="titulo">Adicionar nova Estampa</h3>
                        <div class="group-2">
                            <a>Nesta secção, podes adicionar uma nova imagem para possível estampagem.</a>
                            <form method="POST" action="{{ route('usuario.estampa.store') }}" class="input" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="img">Seleciona uma imagem:</label>
                                    <input type="text" name="nome" class="form-control" value="{{old('nome', $estampa->nome)}}" placeholder="Nome da Imagem" required>
                                    @error('nome')
                                        <div class="small text-danger">O campo do nome é obrigatorio</div>
                                    @enderror
                                    <input type="text" name="descricao" class="form-control" value="{{old('descricao', $estampa->descricao)}}" placeholder="Descrição da Imagem">
                                    <input type="file" id="inputFoto" class="form-control" name="foto" accept="image/jpeg, image/png"
                                       onchange="document.getElementById('img-selecionada').src = window.URL.createObjectURL(this.files[0])">
                                    @error('foto')
                                        <div class="small text-danger">O campo da foto é obrigatorio</div>
                                    @enderror
                                </div>
                                <div class="img-carregada">
                                    <label>Pré-visualização</label>
                                    <img id="img-selecionada" alt="Imagem não carregada"/>
                                </div>

                                @csrf
                                <div class="form-group text-right">
                                    <div class="add-cart">
                                        <button type="submit" name="ok">Adicionar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
