<?php

namespace App\Jobs;

use App\Models\Coupon;
use App\Models\Event;
use App\Models\JobStatus;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ZipArchive;
use Illuminate\Support\Facades\Storage;

class GenerateMassivePDFJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $idEvent;

    public function __construct($idEvent)
    {
        $this->idEvent = $idEvent;
    }

    public function handle()
    {
        $batchSize = 500;
        $offset = 0;

        $jobStatus = JobStatus::create([
            'job_id' => $this->job->getJobId(),
            'event_id' => $this->idEvent,
            'status' => 'processing(zip)',
            'progress' => 0,
        ]);
        do {
            // Obtener cupones no consumidos con paginación
            $coupons = Coupon::where('event_id', $this->idEvent)
                ->where('is_consumed', false)
                ->skip($offset)
                ->take($batchSize)
                ->get();

            // Si no hay cupones, salir
            if ($coupons->isEmpty()) {
                break;
            }

            // Crear un array para almacenar los PDFs temporales
            $pdfFiles = [];
            foreach ($coupons as $coupon) {
                $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($coupon->qrCode);
                $pdf = Pdf::loadView('pdf.coupon', compact('coupon', 'qrCodeBase64'));

                // Guardar el PDF temporalmente
                $pdfPath = storage_path('app/public/cupons/cupon_' . $coupon->id . '_' . $coupon->numeric_code . '.pdf');
                $pdf->save($pdfPath);
                $pdfFiles[] = $pdfPath;
            }

            // Crear el archivo ZIP
            $zip = new ZipArchive();
            $zipFileName = 'cupones_evento_' . str_replace(' ', '_', Event::find($this->idEvent)->name) . '_offset_' . $offset . '.zip';
            $zipPath = storage_path('app/public/cupons/' . $zipFileName);

            if ($zip->open($zipPath, ZipArchive::CREATE) !== TRUE) {
                throw new \Exception('No se pudo crear el archivo ZIP');
            }

            foreach ($pdfFiles as $file) {
                $zip->addFile($file, basename($file));
            }

            $zip->close();

            // Eliminar archivos PDF temporales
            foreach ($pdfFiles as $file) {
                unlink($file);
            }

            // Guardar el nombre del archivo ZIP generado en la base de datos
            Storage::disk('public')->put('cupons/' . $zipFileName, file_get_contents($zipPath));

            $offset += $batchSize;
            if (($offset + 1) % 200 == 0) {
                $jobStatus->progress = $offset + 1;
                $jobStatus->save();
            }
        } while (true);

        // Marcar como completado
        $jobStatus->update([
            'status' => 'completed',
            'progress' => $offset,
        ]);
    }
}
