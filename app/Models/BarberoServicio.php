<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarberoServicio extends Model
{
    use HasFactory;

    // Especificar el nombre de la tabla
    protected $table = 'barbero_servicios';

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'barbero_id',
        'servicio_id',
    ];

    // Relación con Barbero
    public function barbero()
    {
        return $this->belongsTo(Barbero::class);
    }

    // Relación con Servicio
    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
}
