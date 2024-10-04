<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'guid',
        'numeric_code',
        'event_id',
        'ticket_type_id',
        'is_consumed',
        'event_assistant_id',
        'qrCode',
    ];

    protected static function boot()
    {
        parent::boot();

        // Generar un UUID y un código numérico único al crear el modelo
        static::creating(function ($coupon) {
            $coupon->guid = (string) Str::uuid();
            $coupon->numeric_code = Coupon::generateUniqueNumericCode($coupon->event_id);
        });
    }

    // Método para generar un código numérico único de 6 dígitos por evento
    public static function generateUniqueNumericCode($event_id)
    {
        do {
            // Generar un código numérico de 6 dígitos
            $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            // Verificar si ya existe un código igual para el mismo event_id
        } while (self::where('numeric_code', $code)->where('event_id', $event_id)->exists());

        return $code;
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function ticketType()
    {
        return $this->belongsTo(TicketType::class);
    }

    public function eventAssistant()
    {
        return $this->belongsTo(EventAssistant::class, 'event_assistant_id');
    }

}
