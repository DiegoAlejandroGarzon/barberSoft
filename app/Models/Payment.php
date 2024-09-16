<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_assistant_id',
        'payer_name',
        'payer_document_type',
        'payer_document_number',
        'amount',
        'payment_method',
        'payment_proof',
        'description',
    ];

    public function eventAssistant()
    {
        return $this->belongsTo(EventAssistant::class);
    }
}
