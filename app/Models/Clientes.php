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

        $total_clientes = Clientes::count();

        return $total_clientes;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function encomendas()
    {
        return $this->hasMany(Encomendas::class);
    }
}
