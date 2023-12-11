<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidosSaidas extends Model
{
    use HasFactory;

    protected  $fillable = [
        "ipi",
        "cOutro",
        "user_id",
        "empresa_id",
        "pedido_id",
        "produto_id",
        "quantidade",
        "vDescC",
        "vDescIC",
        "vFrete",
        "vICMS",
        "vSeg",
        "vUnit",
    ];
}
