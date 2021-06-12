@extends('partials.header_footer')
@section('content')
<title>{{$estampa->nome}}</title>
	<div class="products">
		<div class="container">
			<!-- Conteudo -->
			<div class="row">
				<div class="col-sm-6">
					<div class="images">
						<!-- <h3>Imagens do Produto</h3> -->
						<section id="slider">
							<!--slider-->
							<div class="container">
								<div class="row">
									<div class="col-sm-6">
										<div class="carousel-inner">	
											<div class="active item">
												<div class="col-sm-12">
													<img id="myImage" src="/storage/tshirt_base/{{$cores[0]->codigo}}.jpg" alt="" />
												</div>
											</div>
											@if($estampa->cliente_id)
												<img src="{{ route('catalogo.estampa.privada', $estampa) }}" class="estampa_tshirt"  alt="" />
											@else
												<img src="{{$estampa->imagem_url ? asset('storage/estampas/' . $estampa->imagem_url) : asset('img/default_img.png') }}" class="estampa_tshirt"  alt=""/>
											@endif
										</div>
									</div>
								</div>
							</div>
						</section>
						<!--/slider-->
					</div>
				</div>
				<div class="col-sm-6">
					<div class="data">
						<h1>Estampa: {{$estampa->nome}}</h1><br>
						@if($estampa->descricao)
							<h5>Descrição: {{$estampa->descricao}}</h5> 
						@endif
						<a>Selecione as opções abaixo apresentadas para configurar a t-shirt.</a>
						<h3>Tamanho</h3>
						<form class="tamanho">
							<label>
								<input type="radio" name="tam">
								<span class="checkmark">XS</span>
							</label>
							<label>
								<input type="radio" name="tam">
								<span class="checkmark">S</span>
							</label>
							<label>
								<input type="radio" name="tam">
								<span class="checkmark">M</span>
							</label>
							<label>
								<input type="radio" name="tam">
								<span class="checkmark">L</span>
							</label>
							<label>
								<input type="radio" name="tam">
								<span class="checkmark">XL</span>
							</label>
						</form>
						<h3>Cor</h3>
							<form class="cor">
								<div class="linha2-cores">
									<select class="select-dropdown" id="mySelect" name="cor" onchange="mudar_tshirt()">
									@foreach($cores as $cor)
											<option name="cor" value="{{$cor->nome}}">{{$cor->nome}}</option>
									@endforeach	
									</select>										
								</div>	
							</form>
						<div class="preco">
							<div class="quantidade">
								<h3>Quantidade </h3>
								<div class="o">
									<button id="botao" onclick="decrementar()">-</button>
								</div>
								<input type="text" name="quantidade" id="quantidade" value="1">
								<div class="o">
									<button id="botao" onclick="incrementar()">+</button>
								</div>
							</div>
							<div class="valor">
								<h3>Preço Base</h3>
								@if($estampa->cliente_id == null)
								<h4>{{$preco->preco_un_catalogo}} €</h4>
								@else
								<h4>{{$preco->preco_un_proprio}} €</h4>
								@endif
							</div>
							<div class="desconto">
								@if($estampa->cliente_id == null)
									<a>Na compra de {{$preco->quantidade_desconto}} T-shirts o preço de cada fica a: {{$preco->preco_un_catalogo_desconto}} €</a>
								@else
									<a>Na compra de {{$preco->quantidade_desconto}} T-shirts o preço de cada fica a: {{$preco->preco_un_proprio_desconto}} €</a>
								@endif
							</div>

						</div>
						<div class="entrega-prevista">
							<a>Entrega prevista em 3 dias úteis</a>
						</div>
						<div class="add-cart">
							<button>Adicionar ao carrinho</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<script> var cores = <?php echo json_encode($cores->toArray()); ?>;</script>
@endsection
