<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reunion extends Model
{
    use HasFactory;

    protected $table = 'reunion';

    protected $fillable = ['description','fecha_programada','asuntos'];
}
