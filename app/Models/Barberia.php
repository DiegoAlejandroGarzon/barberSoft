<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barberia extends Model
{
    use HasFactory;

    protected $table = "barberias";

    protected $fillable = [
        'nombre',
        'ubicacion',
        'contacto',
        'status',
        'logo',
    ];

    // Relación con los barberos
    public function barberos()
    {
        return $this->hasMany(Barbero::class);
    }

    // Relación con los horarios de la barbería
    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }

    // Relación con las citas de la barbería
    public function citas()
    {
        return $this->hasManyThrough(Cita::class, Barbero::class);
    }

    // Relación con los servicios de la barbería
    public function servicios()
    {
        return $this->hasManyThrough(Servicio::class, Barbero::class);
    }
}
