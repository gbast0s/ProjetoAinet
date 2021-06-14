@extends('partials.header_footer')
@section('content')
	<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				</ol>
			</div>
			<div class="table-responsive cart_info">
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Produto</td>
							<td class="description">Nome</td>
							<td class="price">Tamanho</td>
							<td class="price">Cor</td>
							<td class="quantity">Quantidade</td>
							<td class="total">Total</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						@foreach($carrinho as $pedido)
						<tr>
							<td class="cart_product">
								@if($pedido['estampa']->cliente_id)
									<img src="{{ route('catalogo.estampa.privada', $pedido['estampa']) }}" class="estampa_tshirt"  alt="" />
								@else
									<img src="/storage/tshirt_base/{{$pedido['cor']}}.jpg" alt="" />
									<img src="{{$pedido['estampa']->imagem_url ? asset('storage/estampas/' . $pedido['estampa']->imagem_url) : asset('img/default_img.png') }}" class="estampa_tshirt"  alt=""/>
								@endif
							</td>
							<td class="cart_description">
								<h4>{{$pedido['nome_estampa']}}</h4>
							</td>
							<td class="cart_tam">
								<p>{{$pedido['tam']}}</p>
							</td>
							<td class="cart_cor">
								<p>{{$pedido['cor']->nome}}</p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">
									<a class="cart_quantity_up" href=""> + </a>
										<label>{{$pedido['qtd']}}</label>
									<a class="cart_quantity_down" href=""> - </a>
								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">{{$pedido['preco']}} €</p>
							</td>
							<td class="cart_delete">
								<a class="cart_quantity_delete" href=""><i class="fa fa-times"></i></a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</section> <!--/#cart_items-->

	<a class="btn btn-default update" href="{{ route('carrinho') }}">Atualizar</a>
	<a class="btn btn-default check_out" href="{{ route('usuario.checkout') }}">Check Out</a>
@endsection