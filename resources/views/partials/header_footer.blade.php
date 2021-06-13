<!DOCTYPE html>
<html lang="pt">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="/img/icon.png">
		<link href="{{ asset('css/estilos.css') }}" rel="stylesheet">
		<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
		<link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
		<link href="{{ asset('css/prettyPhoto.css') }}" rel="stylesheet">
		<link href="{{ asset('css/price-range.css') }}" rel="stylesheet">
		<link href="{{ asset('css/animate.cs') }}s" rel="stylesheet">
		<link href="{{ asset('css/main.css') }}" rel="stylesheet">
		<link href="{{ asset('css/responsive.css') }}" rel="stylesheet">
	</head>
	<!--/head-->

	<body>
		<header id="header">
			<!--header-->
			<div class="header-middle">
				<!--header-middle-->
				<div class="container">
					<div class="row">
						<div class="col-sm-4">
							<div class="logo pull-left">
								<a href="{{ route('home') }}"><img src="/img/logo.png" alt="MagicShirts" /></a>
							</div>
						</div>
						<div class="col-sm-8">
							<div class="shop-menu pull-right">
								<ul class="nav navbar-nav">
									<li><a href="{{ route('usuario.perfil') }}"><i class="fa fa-user"></i> A minha conta</a></li>
									<li><a href="{{ route('carrinho') }}"><i class="fa fa-shopping-cart"></i> Carrinho</a></li>
									@auth
									@if(Auth::user()->tipo == 'A')
										<li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Administração</a></li>
									@elseif(Auth::user()->tipo == 'F')
										<li><a href="{{ route('admin.encomendas') }}"><i class="fa fa-dashboard"></i> Administração</a></li>
									@endif
									<li><a href="{{route('logout')}}" onclick="event.preventDefault();
															document.getElementById('logout-form').submit();"><i class="fa fa-lock"></i>Logout</a>
									<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
										@csrf
									</form>
									@else
									<li><a href="{{ route('login') }}"><i class="fa fa-lock"></i> Iniciar sessão</a></li>
									@endguest
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--/header-middle-->

			<div class="header-bottom">
				<!--header-bottom-->
				<div class="container">
					<div class="row">
						<div class="col-sm-9">
							<div class="navbar-header">
								<button type="button" class="navbar-toggle" data-toggle="collapse"
									data-target=".navbar-collapse">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
							</div>
							<div class="mainmenu pull-left">
								<ul class="nav navbar-nav collapse navbar-collapse">
									<li><a href="{{ route('home') }}" class="{{Route::currentRouteName() == 'home' ? 'active' : ''}}">Início</a></li>
									<li><a href="{{ route('catalogo') }}" class="{{Route::currentRouteName() == 'catalogo' ? 'active' : ''}}">Catálogo</a></li>
									<li><a href="{{ route('usuario.estampa_personalizada') }}" class="{{Route::currentRouteName() == 'usuario.estampa_personalizada' ? 'active' : ''}}">Estampagem Personalizada</a></li>
								</ul>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="search_bar">
								<form name="barra_pesquisa" action="{{ route('catalogo') }}" method="get">
									<input type="text" placeholder="Pesquise toda a loja aqui" name="estampas">
									<button type="submit"><i class="fa fa-search"></i>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--/header-bottom-->
		</header>
		<!--/header-->
		@if(session('alert-msg'))
			<section id="advertisement">
				<div class="container">
					@include('partials.message')
				</div>
			</section>
		@endif
		@if ($errors->any())
			<section id="advertisement">
				<div class="container">
					@include('partials.errors-message')
				</div>
			</section>
		@endif
		@if (session('notclient'))
			<section id="advertisement">
				<div class="container">
				<div class="alert alert-danger alert-dismissible " role="alert">
						Não pode aceder a essa página visto não ser cliente.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				</div>
			</section>
		@endif 
		@yield('content')
		<footer id="footer">
			<!--Footer-->
			<div class="footer-top">
				<div class="companyinfo">
					<a><img src="/img/logo.png" alt="" /></a>
				</div>
			</div>
			<div class="footer-widget">
				<div class="container">
					<div class="row">
						<div class="col-sm-2">
							<div class="single-widget">
								<h2>Métodos de pagamento</h2>
								<ul class="nav nav-pills nav-stacked">
									<li><a href="https://www.mastercard.pt/" target="_blank">Mastercard</a></li>
									<li><a href="https://www.visa.pt/" target="_blank">VISA</a></li>
									<li><a href="https://www.paypal.com/" target="_blank">PayPal</a></li>
								</ul>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="single-widget">
								<h2>Redes Sociais</h2>
								<ul class="nav nav-pills nav-stacked">
									<li><a href="#"><i class="fa fa-facebook"></i>Facebook</a></li>
									<li><a href="#"><i class="fa fa-linkedin"></i>LinkedIn</a></li>
									<li><a href="#"><i class="fa fa-instagram"></i>Instragam</a></li>
									<li><a href="#"><i class="fa fa-twitter"></i>Twitter</a></li>
								</ul>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="single-widget">
								<h2>Sobre o MagicShirts</h2>
								<ul class="nav nav-pills nav-stacked">
									<li><a>Desenvolvido para projeto de AINet 2020/2021</a></li>
									<br>
									<li><p>Gonçalo Bastos &nbsp (...)</p></li>
									<li><p>Sandro Baptista &nbsp 2191217</p></li>
									<li><p>Xavier Marques &nbsp (...)</p></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<!--/Footer-->
		<script src="{{ asset('js/app.js') }}"></script>
		<script src="{{ asset('js/jquery.js') }}"></script>
		<script src="{{ asset('js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('js/jquery.scrollUp.min.js') }}"></script>
		<script src="{{ asset('js/price-range.js') }}"></script>
		<script src="{{ asset('js/main.js') }}"></script>
		@if(Route::currentRouteName()=='usuario.perfil')
			@if($errors->first())
				<script> window.onload = function() {alterarConta();}; </script>
			@endif
		@endif
	</body>
</html>