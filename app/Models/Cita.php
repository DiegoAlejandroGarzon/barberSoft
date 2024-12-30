<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $table = 'citas';

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'cliente_id',
        'empleado_id',
        'fecha_hora',
        'estado',
    ];

    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Relación con Barbero
    public function barbero()
    {
        return $this->belongsTo(Empleado::class);
    }

    // Relación con los Servicios (muchos a muchos)
    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'cita_servicio');
    }
}
