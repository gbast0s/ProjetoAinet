<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clientes extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [

        'nif', 'endereco', 'tipo_pagamento', 'ref_pagamento'

    ];

    public static function totalClientes(){

        $total_clientes = 0;

        $clientes = Clientes::all();

        foreach($clientes as $cliente)
        {
            $total_clientes += 1; 
        }

        return $total_clientes;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
