<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class citaServicio extends Model
{
    use HasFactory;

    // Especificar el nombre de la tabla
    protected $table = 'cita_servicio';

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'cita_id',
        'servicio_id',
    ];

    // Relación con Cita
    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }

    // Relación con Servicio
    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
}
