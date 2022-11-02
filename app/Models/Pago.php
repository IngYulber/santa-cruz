<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pago';

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',

    ];

    protected $fillable = ['fecha_inicio','fecha_fin','monto','descripcion'];
}
