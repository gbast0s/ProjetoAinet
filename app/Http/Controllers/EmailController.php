<?php

namespace App\Http\Controllers;

use App\Mail\NovaCompra;
use App\Models\Encomendas;
use App\Models\Tshirts;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\Fatura;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public static function enviar_email_encomenda_pendete(Encomendas $encomenda)
    {
        // SEND EMAIL WITH MAILABLE CLASS
        // Send to user:
        //$user = User::findOrFail(Auth::user()->id);
        $tshirts = Tshirts::where('encomenda_id', $encomenda->id)->get();

        Mail::to($user)
            ->send(new NovaCompra($encomenda, $tshirts));
    }

    public static function enviar_email_com_fatura(Encomendas $encomenda)
    {
        // SEND EMAIL WITH USER MODEL
        $fatura = $encomenda->recibo_url;
        // Send to user:
        $user = User::findOrFail($encomenda->cliente->user->id);
        $user->notify(new Fatura($fatura));
        return redirect()->route('admin.encomendas');
    }
}
