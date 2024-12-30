<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Empresa extends Model
{
    use HasFactory;

    protected $table = "empresas";

    protected $fillable = [
        'nombre',
        'ubicacion',
        'contacto',
        'status',
        'logo',
        'color_one',
        'color_two',
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

    // Relación con los horarios de la empresa
    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }

    // Relación con las citas de la empresa
    public function citas()
    {
        return $this->hasManyThrough(Cita::class, Empleado::class);
    }

    // Relación con los servicios de la empresa
    public function servicios()
    {
        return $this->hasManyThrough(Servicio::class, Empleado::class);
    }

    public function empleados(): BelongsToMany
    {
        return $this->belongsToMany(Empleado::class, 'empleado_empresa');
    }
}
