<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmissoesFocus extends Model
{
    use HasFactory;

    protected $fillable = [
        "empresa",
        "fornecedor",
        "user_id",
        "pedido_id",
        "ref",
        "status",
        "mensagem",
        "link_xml",
        "link_danfe"
    ];
}
