<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpleadoServicio extends Model
{
    use HasFactory;

    // Especificar el nombre de la tabla
    protected $table = 'empleado_servicios';

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'empleado_id',
        'servicio_id',
    ];

    // Relación con empleado
    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    // Relación con Servicio
    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
}
