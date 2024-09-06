<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventAssistant extends Model
{
    use HasFactory;

    protected $table = "event_assistants";

    protected $fillable = [
        'event_id',
        'user_id',
        'ticket_type_id',
        'has_entered',
        'qrCode',
        'guid',
        'entry_time',
        'rejected',
        'rejected_time',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ticketType()
    {
        return $this->belongsTo(TicketType::class, 'ticket_type_id');
    }
}
