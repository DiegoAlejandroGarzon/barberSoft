<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function generatePDF($id)
    {
        // Obtener el pago específico por ID
        $payment = Payment::findOrFail($id);

        // Generar la vista en formato PDF
        $pdf = PDF::loadView('pdf.payment', compact('payment'));

        return $pdf->stream('detalle_pago_'.$payment->payer_name.'.pdf');
        // return $pdf->download('payment_details_' . $payment->id . '.pdf');
    }
}
