<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;
use Auth;

class IsEstampaValida
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
        $id_cliente = $request->route('estampa')->cliente_id;
        
        if ($id_cliente == null) {
            return $next($request);
        }
        elseif(Auth::user() != null && Auth::user()->id == $id_cliente)
        {
            return $next($request);  
        }
        else
        {
            throw new AuthorizationException();
        }
    }
}
