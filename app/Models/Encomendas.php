<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Encomendas extends Model
{
    use HasFactory;

    protected $fillable = [

        'estado', 'cliente_id', 'data', 'preco_total','notas', 'nif', 'endereco', 'tipo_pagamento', 'ref_pagamento', 'recbio_url'

    ];

    public static function ganhosMensais()
    {
        $total = 0;
        $data = date("Y-m");

        $total = Encomendas::where('data', 'LIKE', $data . '%')->where('estado', 'fechada')->sum('preco_total');

        $mes = FuncoesAuxiliares::converterNumMes();

        $retorno = [$total, $mes];

        return $retorno;

    }

    public static function ganhosAnuais()
    {
        $total = 0;
        $data = date("Y");

        $total = Encomendas::where('data', 'LIKE', $data . '%')->where('estado', 'fechada')->sum('preco_total');

        return $total;

    }

    public static function encomendasPendentes()
    {
        $total_encomendas = 0;

        $total_encomendas = Encomendas::where('estado', 'pendente')->count();

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

    public function tshirts()
    {
        return $this->hasMany(Tshirts::class);
    }
}
