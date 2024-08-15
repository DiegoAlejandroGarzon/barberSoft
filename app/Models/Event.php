<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'header_image_path',
        'created_by',
        'additionalFields',
    ];


    public function ticketTypes()
    {
        return $this->hasMany(TicketType::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function assistants()
    {
        return $this->hasMany(EventAssistant::class);
    }
}
