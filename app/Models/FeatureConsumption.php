<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeatureConsumption extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_assistant_id',
        'ticket_feature_id',
        'consumed_at',
    ];

    public function eventAssistant()
    {
        return $this->belongsTo(EventAssistant::class);
    }

    public function ticketFeature()
    {
        return $this->belongsTo(TicketFeatures::class);
    }
}
