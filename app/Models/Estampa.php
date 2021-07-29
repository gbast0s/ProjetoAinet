<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estampa extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['cliente_id', 'categoria_id', 'nome', 'descricao', 'imagem_url', 'informacao_extra'];

    public function categoria()
    {
        return $this->belongsTo(Categorias::class, 'categoria_id');
    }

    public function tshirts()
    {
        return $this->hasMany(Tshirts::class);
    }
}
