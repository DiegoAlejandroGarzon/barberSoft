<?php

namespace App\Jobs;

use App\Models\Coupon;
use App\Models\Event;
use App\Models\JobStatus;
use App\Models\Ticket;
use App\Models\TicketType;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class GenerateCouponsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $eventId;
    protected $ticketTypeId;
    protected $numberOfCoupons;

    public function __construct($eventId, $ticketTypeId, $numberOfCoupons)
    {
        $this->eventId = $eventId;
        $this->ticketTypeId = $ticketTypeId;
        $this->numberOfCoupons = $numberOfCoupons;
    }

    public function handle()
    {
        $jobStatus = JobStatus::create([
            'job_id' => $this->job->getJobId(),
            'event_id' => $this->eventId,
            'status' => 'processing',
            'progress' => 0,
        ]);
        for ($i = 0; $i < $this->numberOfCoupons; $i++) {
            // Lógica para generar cupones, ejemplo básico:
            $coupon = Coupon::create([
                'event_id' => $this->eventId,
                'ticket_type_id' => $this->ticketTypeId,
                'is_consumed' => 0,
            ]);
            // Actualizar progreso cada 100 cupones
            if (($i + 1) % 20 == 0) {
                $jobStatus->progress = $i + 1;
                $jobStatus->save();
            }
        }

        // Marcar como completado
        $jobStatus->update([
            'status' => 'completed',
            'progress' => $this->numberOfCoupons,
        ]);
    }
}
