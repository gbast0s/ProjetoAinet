<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categorias extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nome'];

    public $timestamps = false;

    public function estampas()
    {
        return $this->hasMany(Estampa::class);
    }
}
