<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = ['usuario_id', 'producto_id', 'cantidad', 'precio_total', 'fecha_pedido'];

    public $timestamps = false;
}
