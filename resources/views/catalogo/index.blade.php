@extends('partials.header_footer')
@section('content')
	<title>MagicShirts - Catalogo</title>
	<section class="catalogo">
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="left-sidebar">
						<h2>Categorias</h2>
						<div class="dropdown">
							<button class="dropbtn">Filtrar Estampas</button>
							<div class="dropdown-content scrollable-menu">
								<a href="{{ route('catalogo') }}">Todas as Estampas</a>
								@foreach($categorias as $categoria)
									<a href="{{ route('categoria', $categoria) }}">{{$categoria->nome}}</a>
								@endforeach
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Catálogo</h2>
						@if($estampas)
							@foreach($estampas as $estampa)
							<div class="col-sm-4">
								<div class="product-image-wrapper">
									<div class="single-products">
										<div class="productinfo text-center">
											<img src="{{$estampa->imagem_url ? asset('storage/estampas/' . $estampa->imagem_url) : asset('img/default_img.png') }}" alt="" />
											<p>{{$estampa->nome}}</p>
											<a class="btn btn-default add-to-cart" href="{{ route('catalogo.estampa', $estampa) }}">Ver Produto</a>
										</div>
									</div>
								</div>
							</div>
							@endforeach
						@else
							<h4>Não foram encontradas estampas para a sua pesquisa</h4>
						@endif
					</div><!--features_items-->
					@if($estampas)
						<ul class="pagination">
								{{ $estampas->withQueryString()->links() }}
						</ul>
					@endif
				</div>
			</div>
		</div>
	</section>
@endsection
