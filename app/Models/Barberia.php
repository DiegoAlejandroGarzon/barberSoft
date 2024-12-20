<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->guid)) {
                $model->guid = Str::uuid();
            }
        });
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

    public function barberos(): BelongsToMany
    {
        return $this->belongsToMany(Barbero::class, 'barbero_barberia');
    }
}
