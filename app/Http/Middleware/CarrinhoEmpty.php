<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CarrinhoEmpty
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $carrinho = $request->session()->get('carrinho', []);

        if ($carrinho) {
            return $next($request);
        }

        return redirect()->route('carrinho');
    }
}
