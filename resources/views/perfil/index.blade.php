@extends('partials.header_footer')
@section('content')
<title>MagicShirts - Perfil</title>
	<section class="perfil">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
                    <div class="barra">
                        <div class="mainmenu">
                            <ul class="nav navbar-nav collapse navbar-collapse">
                                <li><a onclick=mostrarConta()>A minha conta</a></li>
                                <li><a onclick=mostrarEncomenda()>As minhas encomendas</a></li>
                                <li><a onclick=alterarConta()>Alterar dados</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="conta" id="suaConta">
                        <h4>A minha conta</h4>
                        <div class="dados-cliente">
                            <a>Neste espaço, podes visualizar todos os seus dados.</a>
                            <p>Dados de cliente registados</p>
                            <div class="lista">
                                <div class="lista-dados-cliente">
                                    <p>Imagem de perfil</p>
                                    <div class="lista-dados-cliente image">
                                        <p><img src="{{ $cliente->user->foto_url ? asset('storage/fotos/' . $cliente->user->foto_url ) : asset('img/default_img.png') }}"></p>
                                    </div>
                                </div>
                                <div class="lista-dados-cliente">
                                    <p>Nome do cliente</p>
                                    <div class="lista-dados-cliente d">
                                        <p>{{$cliente->user->name}}</p>
                                    </div>
                                </div>
                                <div class="lista-dados-cliente">
                                    <p>NIF do cliente</p>
                                    <div class="lista-dados-cliente d">
                                        <p>{{$cliente->nif}}</p>
                                    </div>
                                </div>
                                <div class="lista-dados-cliente">
                                    <p>Endereço</p>
                                    <div class="lista-dados-cliente d">
                                        <p>{{ $cliente->endereco }}</p>
                                    </div>
                                </div>
                                <div class="lista-dados-cliente">
                                    <p>Email</p>
                                    <div class="lista-dados-cliente d">
                                        <p>{{ $cliente->user->email }}</p>
                                    </div>
                                </div>
                                <div class="lista-dados-cliente">
                                    <p>Tipo de pagamento usado</p>
                                    <div class="lista-dados-cliente d">
                                        @if ($cliente->tipo_pagamento == "MC")
                                            <p>MasterCard</p>
                                        @else
                                            <p>{{ $cliente->tipo_pagamento }}</p>
                                        @endif

                                    </div>
                                </div>
                                <div class="lista-dados-cliente">
                                    <p>Referêcia do pagamento</p>
                                    <div class="lista-dados-cliente d">
                                        <p>{{ $cliente->ref_pagamento }}</p>
                                    </div>
                                </div>
                                <div class="lista-dados-cliente">
                                    <p>Data de criação</p>
                                    <div class="lista-dados-cliente d">
                                        <p>{{ $cliente->created_at }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="alterar">
                                <a href="password/reset"><button>Alterar a palavra-passe</button></a>
                                @isset($cliente->user->foto_url)
                                    <button type="submit" name="deletefoto" form="form_delete_photo">Apagar Foto</button>
                                @endisset
                            </div>
                            <form id="form_delete_photo" action="{{route('usuario.clientes.foto.destroy', ['cliente' => $cliente])}}" method="POST">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                    <div class="editar-conta" id="editar">
                        <h4>Edição de dados da conta</h4>
                        <div class="dados-cliente">
                            <a>Neste espaço, podes alterar os teus dados.</a>
                            <p>Dados de cliente para alterar: </p>
                            <div class="lista-editar">
                                <form class="lista-editar2" method="POST" action=" {{ route('usuario.clientes.update', ['cliente' => $cliente]) }}" class="input" enctype="multipart/form-data">
                                    <div class="lista-dados-cliente">
                                        <p>Imagem de perfil</p>
                                        <div class="lista-dados-cliente de">
                                            <p><input type="file" id="inputFoto" class="form-control" name="foto" accept="image/jpeg, image/png"
                                                        onchange="document.getElementById('img-selecionada').src = window.URL.createObjectURL(this.files[0])"></p>
                                            @error('foto')
                                                <div class="small text-danger">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="lista-dados-cliente">
                                        <p>Pré-visualização da imagem de perfil</p>
                                        <div class="lista-dados-cliente de">
                                            <p><img id="img-selecionada" alt="Imagem não carregada"/></p>
                                        </div>
                                    </div>
                                    <div class="lista-dados-cliente">
                                        <p>Nome do cliente</p>
                                        <div class="lista-dados-cliente de">
                                            <p><input type="text" name="name" class="form-control" value="{{ old('name', $cliente->user->name) }}" required></p>
                                        </div>
                                    </div>
                                    @error('name')
                                                <div class="small text-danger">O campo do nome é obrigatório</div>
                                    @enderror
                                    <div class="lista-dados-cliente">
                                        <p>NIF do cliente</p>
                                        <div class="lista-dados-cliente de">
                                            <p><input type="text" name="nif" class="form-control" value="{{ old('nif', $cliente->nif) }}" required></p>
                                        </div>
                                    </div>
                                    @error('nif')
                                        <div class="small text-danger">{{$message}}</div>
                                    @enderror
                                    <div class="lista-dados-cliente">
                                        <p>Endereço</p>
                                        <div class="lista-dados-cliente de">
                                            <p><input type="text" name="endereco" class="form-control" value="{{ old('endereco', $cliente->endereco) }}" required></p>
                                        </div>
                                    </div>
                                    @error('endereco')
                                                <div class="small text-danger">O campo do endereço é obrigatório</div>
                                    @enderror
                                    <div class="lista-dados-cliente">
                                        <p>Email</p>
                                        <div class="lista-dados-cliente de">
                                            <p><input type="email" name="email" class="form-control" value="{{ old('email', $cliente->user->email) }}" required></p>
                                        </div>
                                    </div>
                                    @error('email')
                                                <div class="small text-danger">{{$message}}</div>
                                    @enderror
                                    <div class="lista-dados-cliente">
                                        <p>Tipo de pagamento usado</p>
                                        <div class="lista-dados-cliente de">
                                            <p for="tipo_pagamento">
                                            <select name="tipo_pagamento" id="tipo-pagamento">
                                                <option value="MC" {{ 'MC' == old('tipo_pagamento', $cliente->tipo_pagamento) ? 'selected' : '' }}>MasterCard</option>
                                                <option value="VISA" {{ 'VISA' == old('tipo_pagamento', $cliente->tipo_pagamento) ? 'selected' : '' }}>VISA</option>
                                                <option value="PAYPAL" {{ 'PAYPAL' == old('tipo_pagamento', $cliente->tipo_pagamento) ? 'selected' : '' }}>PayPal</option>
                                            </select></p>
                                        </div>
                                    </div>
                                    <div class="lista-dados-cliente">
                                        <p>Referência de pagamento</p>
                                        <div class="lista-dados-cliente de">
                                            <p><input type="text" name="ref_pagamento" class="form-control" value="{{ old('ref_pagamento', $cliente->ref_pagamento) }}" required></p>
                                        </div>
                                    </div>
                                    @error('ref_pagamento')
                                                <div class="small text-danger">{{$message}}</div>
                                    @enderror
                                    <div class="lista-dados-cliente omissao">
                                        <p>Data de criação</p>
                                        <div class="lista-dados-cliente de">
                                            <p>{{ $cliente->created_at }}</p>
                                        </div>
                                    </div>
                                    @csrf
                                    @method('PUT')
                                    <div class="submeter-edicao">
                                        <button type="submit" name="ok">Submeter edição</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="encomendas" id="suasEncomendas">
                        <h4>Edição de dados da conta</h4>
                        <div class="dados-cliente">
                            <a>Neste espaço, podes alterar os teus dados.</a>
                            <p>Lista de encomendas registadas: </p>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</section>
@endsection
