<?php

namespace App\Observers;

use App\Models\EventAssistant;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class EventAssistantObserver
{
    /**
     * Handle the EventAssistant "created" event.
     */
    public function created(EventAssistant $eventAssistant)
    {
        // Generar un GUID
        $guid = Str::uuid()->toString();
        // Generar el QR Code basado en el ID o alguna otra información del modelo
        $qrContent = route('eventAssistant.qr', ['id' => $eventAssistant->id, 'guid' => $guid]);
        $qrCode = QrCode::format('svg')->size(300)->generate($qrContent);
        // Actualizar el modelo con la ruta del QR Code
        $eventAssistant->update([
            'qrCode' => $qrCode,
            'guid' => $guid,
        ]);
    }

    /**
     * Handle the EventAssistant "updated" event.
     */
    public function updated(EventAssistant $eventAssistant): void
    {
        //
    }

    /**
     * Handle the EventAssistant "deleted" event.
     */
    public function deleted(EventAssistant $eventAssistant): void
    {
        //
    }

    /**
     * Handle the EventAssistant "restored" event.
     */
    public function restored(EventAssistant $eventAssistant): void
    {
        //
    }

    /**
     * Handle the EventAssistant "force deleted" event.
     */
    public function forceDeleted(EventAssistant $eventAssistant): void
    {
        //
    }
}
