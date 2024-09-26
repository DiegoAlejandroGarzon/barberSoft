<?php

namespace App\Http\Controllers;

use App\Exports\PaymentExport;
use App\Exports\TemplatePayloadExport;
use App\Imports\PayloadImport;
use App\Models\Event;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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

    public function downloadTemplate()
    {
        $headers = [
            'Numero de documentos del asistente',
            'Nombre del pagador',
            'Tipo Documento',
            'Numero Documento',
            'Cantidad Pagada',
            'Formato de pago (transferencia, efectivo)',
        ];

        // Crear una instancia de la exportación con los encabezados
        $export = new TemplatePayloadExport($headers);

        // Descargar el archivo Excel
        return Excel::download($export, 'plantilla_Pagos.xlsx');
    }

    // Procesa el archivo de Excel y asigna los asistentes de forma masiva
    public function uploadMassPayload(Request $request, $idEvent)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048', // Validar que sea un archivo Excel
        ]);

        try {
            // Instanciar el importador y recolectar los datos de las importaciones
            $import = new PayloadImport($idEvent);
            Excel::import($import, $request->file('file'));

            // Obtener los detalles de los usuarios agregados y las novedades
            $importedUsers = $import->getImportedUsers();
            $messages = $import->getMessages();

            return redirect()->back()
                            ->with('success', 'Asistentes pagados exitosamente.')
                            ->with('importedUsers', $importedUsers)
                            ->with('messages', $messages);
        } catch (\Exception $e) {
            return redirect()->back()
                            ->with('error', 'Hubo un error al procesar el archivo: ' . $e->getMessage());
        }
    }

    public function exportExcel(Request $request, $idEvent)
    {
        $event = Event::find($idEvent);
        // Obtener la búsqueda, campos seleccionados y parámetros adicionales desde el request
        $search = $request->input('search');
        $selectedFields = json_decode($event->registration_parameters, true) ?? [];
        $additionalParameters = $event->additionalParameters;
        // Exportar el archivo Excel usando los datos proporcionados
        return Excel::download(
            new PaymentExport($idEvent, $selectedFields, $additionalParameters, $search),
            'pagos_de_asistentes_del_evento_'.$event->name.'_'.date('d-m-Y').'.xlsx'
        );
    }

    public function exportExcelPaymentStatus(Request $request, $idEvent)
    {
        $event = Event::find($idEvent);
        // Obtener la búsqueda, campos seleccionados y parámetros adicionales desde el request
        $search = $request->input('search');
        $selectedFields = json_decode($event->registration_parameters, true) ?? [];
        $additionalParameters = $event->additionalParameters;
        // Exportar el archivo Excel usando los datos proporcionados
        return Excel::download(
            new PaymentExport($idEvent, $selectedFields, $additionalParameters, $search, $paymentStatus = true),
            'pagos_de_asistentes_del_evento_'.$event->name.'_'.date('d-m-Y').'.xlsx'
        );
    }

}
