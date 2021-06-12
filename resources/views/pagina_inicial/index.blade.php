@extends('partials.header_footer')
@section('content')
	<title>MagicShirts</title>
	<section id="slider"><!--slider-->
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div id="slider-carousel" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
							<li data-target="#slider-carousel" data-slide-to="1"></li>
						</ol>
						
						<div class="carousel-inner">
							<div class="item active">
								<div class="col-sm-6">
									<h1><span>Magic</span>Shirts</h1>
									<h2>Vários tipos de Tshirts</h2>
									<p>Imensos tamanhos e cores de Tshirts com todo o tipo de estampagens! </p>
								</div>
								<div class="col-sm-6">
									<img src="/img/tshirts.png" class="girl img-responsive" alt="" />
								</div>
							</div>
							<div class="item">
								<div class="col-sm-6">
									<h1><span>Magic</span>Shirts</h1>
									<h2>Estampagens Personalizadas</h2>
									<p>Fazemos Tshirts com estampagens personalizadas. Peça já a sua!</p>
								</div>
								<div class="col-sm-6">
									<img src="/img/estampa_personalizada.png" class="girl img-responsive" alt="" />
								</div>
							</div>							
						</div>
						
						<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
							<i class="fa fa-angle-left"></i>
						</a>
						<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
							<i class="fa fa-angle-right"></i>
						</a>
					</div>
					
				</div>
			</div>
		</div>
	</section><!--/slider-->
	
	<section>
		<div class="container">
			<div class="row">			
				<div class="col-sm-12 padding-right">
					<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Destaques</h2>
						@foreach($estampasIndex as $estampa)
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
					</div>	
				</div>
			</div>
		</div>
	</section>
@endsection
