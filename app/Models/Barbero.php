<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barbero extends Model
{
    use HasFactory;

    protected $table = 'barberos';

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'usuario_id',
        'barberia_id',
        'estado',
        'foto',
    ];

    // Relación con el usuario (barbero es un usuario)
    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Relación con la barbería
    public function barberia()
    {
        return $this->belongsTo(Barberia::class);
    }

    // Si el barbero tiene muchos servicios, puedes agregar esa relación aquí
    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'barbero_servicios');
    }
}
