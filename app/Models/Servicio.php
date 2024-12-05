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
        'barberia_id',
    ];

    public function barberos()
    {
        return $this->belongsToMany(Barbero::class, 'barbero_servicios');
    }

    public function citas()
    {
        return $this->belongsToMany(Cita::class, 'cita_servicios');
    }

    public function barberia()
    {
        return $this->belongsTo(Barberia::class, 'barberia_id');
    }
}
