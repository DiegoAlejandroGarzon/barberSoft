<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $table = 'horarios';

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'empresa_id',
        'hora_inicio',
        'hora_fin',
        'dia_semana',
    ];

    // Relación con la empresa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
