<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'tipo_documento',
        'numero_documento',
        'nombres',
        'apellidos',
        'telefono',
        'correo',
    ];

    // Relación con las Citas (uno a muchos)
    public function citas()
    {
        return $this->hasMany(Cita::class);
    }
}
