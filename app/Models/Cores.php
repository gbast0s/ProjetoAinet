<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cores extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'codigo';
    protected $keyType = 'string';

    protected $fillable = ['codigo', 'nome'];

    public $timestamps = false;
}
