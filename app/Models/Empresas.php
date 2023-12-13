<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresas extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'razao_social',
        'nome_fantasia',
        'cnpj',
        'user_id',
        'telefone',
        'endereco',
        'numero',
        'bairro',
        'cidade',
        'estado',
        'cep'
    ];
}
