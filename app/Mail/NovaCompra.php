<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NovaCompra extends Mailable
{
    use Queueable, SerializesModels;

    private $encomenda;
    private $tshirts;

    public function __construct($encomenda, $tshirts)
    {
        $this->encomenda = $encomenda;
        $this->tshirts = $tshirts;
    }

    public function build()
    {
        return $this->from('noreply@magic_shirts.com')
            ->subject('A tua encomenda está a ser processada')
            ->view('emails.orders.pendente')
            ->with([
                'encomendaId' => $this->encomenda->id,
                'nome_encomenda' => $this->encomenda->cliente->user->name,
                'preco' => $this->encomenda->preco_total,
                'items' => $this->tshirts,
            ]);
    }
}
