<?php

namespace App\Http\Controllers;

use App\Mail\NovaCompra;
use App\Models\Encomendas;
use App\Models\Tshirts;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public static function enviar_email_encomenda_pendete(Encomendas $encomenda)
    {
        // SEND EMAIL WITH MAILABLE CLASS
        // Send to user:
        $user = User::findOrFail(Auth::user()->id);
        $tshirts = Tshirts::where('encomenda_id', $encomenda->id)->get();

        Mail::to($user)
            ->queue(new NovaCompra($encomenda, $tshirts));
    }
}
