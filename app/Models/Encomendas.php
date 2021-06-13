<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encomendas extends Model
{
    use HasFactory;

    public static function ganhosMensais()
    {
        $total = 0;
        $data = date("Y-m");

        $qry = Encomendas::where('data', 'LIKE', $data . '%')->where('estado', 'fechada');

        $encomendas = $qry->get();

        foreach ($encomendas as $encomenda)
        {
           $total+= $encomenda->preco_total;
        }

        $mes = FuncoesAuxiliares::converterNumMes();

        $retorno = [$total, $mes];

        return $retorno;

    }

    public static function ganhosAnuais()
    {
        $total = 0;
        $data = date("Y");

        $qry = Encomendas::where('data', 'LIKE', $data . '%')->where('estado', 'fechada');

        $encomendas = $qry->get();

        foreach ($encomendas as $encomenda)
        {
           $total+= $encomenda->preco_total;
        }

        return $total;

    }

    public static function encomendasPendentes()
    {
        $total_encomendas = 0;

        $qry = Encomendas::where('estado', 'pendente');

        $encomendas = $qry->get();

        foreach ($encomendas as $encomenda)
        {
           $total_encomendas += 1;
        }

        return $total_encomendas;

    }

    public static function ganhosMensaisGrafico($ano)
    {
        $total_mes = array( 
        "01" => "0",
        "02" => "0",
        "03" => "0",
        "04" => "0",
        "05" => "0",
        "06" => "0",
        "07" => "0",
        "08" => "0",
        "09" => "0",
        "10" => "0",
        "11" => "0",
        "12" => "0");

        //$data = date("Y");
        $data = $ano;

        $qry = Encomendas::where('data', 'LIKE', $data . '%')->where('estado', 'fechada');

        $encomendas = $qry->get();

        //dd($encomendas);

        foreach ($encomendas as $encomenda)
        {
            $partes = explode("-", $encomenda->data);
            $total_mes[$partes[1]] += $encomenda->preco_total;
        }

        //dd($total_mes);

        return $total_mes;

    }

    public function cliente()
    {
        return $this->belongsTo(Clientes::class, 'cliente_id');
    }
}
