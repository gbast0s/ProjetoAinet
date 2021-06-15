<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tshirts extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function estampa()
    {
        return $this->belongsTo(Estampa::class, 'estampa_id');
    }

    public function cor()
    {
        return $this->belongsTo(Cores::class, 'cor_codigo');
    }
}
