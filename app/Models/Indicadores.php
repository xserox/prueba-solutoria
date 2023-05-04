<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\DatosController;

class Indicadores extends Model
{
    use HasFactory;

    protected $dates = [
        'fechaIndicador',
        'updated_at',
        'created_at'
    ];

    // Campos que pueden ser llenados en la tabla indicadores en la base de datos
    protected $fillable = [
        'nombreIndicador', 
        'codigoIndicador', 
        'unidadMedidaIndicador', 
        'valorIndicador', 
        'fechaIndicador', 
    ];
}
