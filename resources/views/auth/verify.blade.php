@extends('layout_admin')
@section('titulo', 'MagicShirts - Verificação Email')
@section('content')
<title>MagicShirts - Verificação Email</title>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verifica o teu endereço de Email') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Foi enviado um novo link de verificação para o teu endereço de email.') }}
                        </div>
                    @endif

                    {{ __('Antes de continuares, verifica o teu endereço de email através do link que recebeste no mesmo.') }}
                    {{ __('Senão recebeste nenhum email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('carrega aqui para pedires outro') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
