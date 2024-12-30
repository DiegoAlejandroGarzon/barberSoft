<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;
    protected $table = 'servicios';

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'precio',
        'descripcion',
        'empresa_id',
    ];

    public function empleados()
    {
        return $this->belongsToMany(Empleado::class, 'empleado_servicios');
    }

    public function citas()
    {
        return $this->belongsToMany(Cita::class, 'cita_servicios');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
}
