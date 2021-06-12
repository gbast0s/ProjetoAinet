<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompraController extends Controller
{
    public function carrinho()
    {
        return view('compra.carrinho');
    }

    public function checkout()
    {
        return view('compra.checkout');
    }
}
