<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Empleado extends Model
{
    use HasFactory;

    protected $table = 'empleados';

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'usuario_id',
        'empresa_id',
        'estado',
        'foto',
    ];

    // Relación con el usuario (empleado es un usuario)
    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Si el empleado tiene muchos servicios, puedes agregar esa relación aquí
    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'empleado_servicios');
    }

    public function empresas(): BelongsToMany
    {
        return $this->belongsToMany(Empresa::class, 'empleado_empresa');
    }
}
