<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->guid)) {
                $model->guid = Str::uuid();
            }
        });
    }

    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Relación con empleado
    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    // Relación con los Servicios (muchos a muchos)
    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'cita_servicio');
    }
}
