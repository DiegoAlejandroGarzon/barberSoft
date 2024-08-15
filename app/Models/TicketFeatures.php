<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketFeatures extends Model
{
    use HasFactory;

    protected $table = "ticket_features";

    protected $fillable = ['name'];

    public function ticketTypes()
    {
        return $this->belongsToMany(TicketType::class, 'ticket_type_feature', 'ticket_feature_id', 'ticket_type_id');
    }
}
