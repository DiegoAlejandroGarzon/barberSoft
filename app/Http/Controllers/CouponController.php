<?php

namespace App\Http\Controllers;

use App\Exports\CouponExport;
use App\Models\AdditionalParameter;
use App\Models\Coupon;
use App\Models\Departament;
use App\Models\Event;
use App\Models\EventAssistant;
use App\Models\TicketType;
use App\Models\User;
use App\Models\UserEventParameter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use setasign\Fpdi\Fpdi;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Facades\Excel;

class CouponController extends Controller
{
    public function index($idEvent){
        $coupons = Coupon::where('event_id', $idEvent)
        ->orderBy('is_consumed', 'asc') // Ordenar por is_consumed: false (0) primero
        ->paginate(10);
        $event = Event::find($idEvent);
        $tickets = TicketType::where('event_id', $idEvent)->get();
        // Contar cuántos cupones hay por cada tipo de ticket
        $couponsByTicket = Coupon::select('ticket_type_id', DB::raw('count(*) as total'))
            ->where('event_id', $idEvent)
            ->groupBy('ticket_type_id')
            ->get()
            ->pluck('total', 'ticket_type_id'); // Retornar una colección con ticket_type_id como clave y total como valor

        // Contar cuántos cupones han sido consumidos por cada tipo de ticket
        $consumedCouponsByTicket = Coupon::select('ticket_type_id', DB::raw('count(*) as consumed'))
            ->where('event_id', $idEvent)
            ->where('is_consumed', true) // Solo los cupones consumidos
            ->groupBy('ticket_type_id')
            ->get()
            ->pluck('consumed', 'ticket_type_id'); // Retornar una colección con ticket_type_id como clave y total consumido como valor

        // Pasar los datos a la vista
        return view('coupon.index', compact('coupons', 'tickets', 'idEvent', 'event', 'couponsByTicket', 'consumedCouponsByTicket'));
    }

    public function generatePDF($id)
    {
        $coupon = Coupon::findOrFail($id);
        // Generar QR code como base64
        $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($coupon->qrCode);

        $pdf = Pdf::loadView('pdf.coupon', compact('coupon', 'qrCodeBase64'));

        //se muestra en una nueva ventana
        return $pdf->stream('cupon_'.$coupon->numeric_code.'.pdf');
        // Se descarga,
        // return $pdf->download('Asistente_Evento_' . $asistente->user->name . '.pdf');
    }

    public function generatePDFMasivo($idEvent)
    {
        // Obtener todos los cupones no consumidos del evento
        $coupons = Coupon::where('event_id', $idEvent)
            ->where('is_consumed', false)
            ->get();

        // Crear un array para almacenar los nombres de los PDFs
        $pdfFiles = [];

        foreach ($coupons as $coupon) {
            // Generar QR code como base64
            $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($coupon->qrCode);

            // Generar el PDF individual
            $pdf = Pdf::loadView('pdf.coupon', compact('coupon', 'qrCodeBase64'));

            // Guardar el PDF temporalmente
            $pdfPath = storage_path('app/public/cupons/cupon_'.$coupon->id.'_'.$coupon->numeric_code . '.pdf');
            $pdf->save($pdfPath);
            $pdfFiles[] = $pdfPath; // Agregar la ruta del archivo PDF al array
        }

        // Combinar todos los PDFs generados
        $combinedPdf = new Fpdi();

        foreach ($pdfFiles as $file) {
            // Importar el contenido de cada PDF
            $pageCount = $combinedPdf->setSourceFile($file);
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $templateId = $combinedPdf->importPage($pageNo);
                $combinedPdf->AddPage();
                $combinedPdf->useTemplate($templateId);
            }
        }
        $event = Event::find($idEvent);
        $nombreConGuionBajo = str_replace(' ', '_', $event->name);
        // Generar el archivo combinado
        $outputPath = storage_path('app/public/cupons/cupones_'.$nombreConGuionBajo.'_'.date("Y-m-d_Hi").'.pdf');
        $combinedPdf->Output($outputPath, 'F'); // Guardar el PDF combinado en el servidor

        // Opcionalmente, puedes eliminar los PDFs temporales si ya no los necesitas
        foreach ($pdfFiles as $file) {
            unlink($file);
        }

        // Retornar el PDF combinado al navegador
        return response()->download($outputPath)->deleteFileAfterSend(true);
    }

    public function infoQrCoupon($id, $public_link)
    {
        // Buscar el asistente por su ID
        $coupon = Coupon::findOrFail($id);
        $ticketTypes  = TicketType::where('event_id', $coupon->event_id)->get();
        $departments = Departament::all();
        $additionalParameters = json_decode($coupon->event->additionalParameters, true) ?? [];

        if($coupon->guid != $public_link){
            abort(404); // Devuelve un error 404 Not Found
        }
        if($coupon->is_consumed){
            return view('coupon.qr.couponConsumed', compact('coupon'));
        }
        return view('coupon.qr.register', compact('coupon', 'ticketTypes', 'departments', 'additionalParameters'));
    }

    public function submitPublicRegistration(Request $request, $public_link)
    {
        $coupon = Coupon::where('guid', $public_link)->firstOrFail();
        $event = Event::find($coupon->event_id);
        if($event->status == 4 ? true : false){
            return redirect()->back()
            ->with('error', 'No se puede realizar está acción porque el evento ya ha sido finalizado.');
        }
        if($coupon->is_consumed){
            return redirect()->back()
            ->with('error', 'No se puede realizar está acción porque el CUPON ya ha sido consumido.');
        }

        $registrationParameters = json_decode($event->registration_parameters, true) ?? [];

        // Construir reglas de validación dinámicas
        $validationRules = [];
        foreach ($registrationParameters as $param) {
            switch ($param) {
                case 'name':
                case 'lastname':
                    $validationRules[$param] = 'required|string|max:255';
                    break;
                case 'email':
                    $validationRules[$param] = 'required|email|max:255|unique:users,email';
                    break;
                case 'type_document':
                    $validationRules[$param] = 'required|string|max:3';
                    break;
                case 'document_number':
                    $validationRules[$param] = 'required|string|max:20|unique:users,document_number';
                    break;
                case 'phone':
                    $validationRules[$param] = 'nullable|string|max:15'; // Suponiendo que es opcional
                    break;
                case 'city_id':
                    $validationRules[$param] = 'nullable|exists:cities,id'; // Asegúrate de que la ciudad exista
                    break;
                case 'birth_date':
                    $validationRules[$param] = 'nullable|date'; // Opcional, formato de fecha
                    break;
                // Agrega más parámetros según sea necesario
            }
        }

        // Validar el request
        $validatedData = $request->validate($validationRules);

        // Obtener las columnas definidas en $fillable del modelo User
        $user = new User();
        $userFillableColumns = (new User())->getFillable();
        $createData = []; // Inicializar el array para los datos de creación
        // Recorrer las columnas permitidas y verificar si están presentes en el request
        foreach ($userFillableColumns as $column) {
            if ($request->has($column)) {
                $createData[$column] = $request[$column];
            }
        }
        $createData['status'] = false;
        $user = User::create($createData);

        // Verificar si el usuario tiene el rol de 'assistant', si no, asignarlo
        if (!$user->hasRole('assistant')) {
            $assistantRole = Role::firstOrCreate(['name' => 'assistant']); // Crear el rol si no existe
            $user->assignRole($assistantRole);
        }
        $guardianId = $request->input('guardian_id') ?? null; // Asegúrate de que tu formulario tenga este campo

        // Crear el registro en la tabla `event_assistant` si no existe
        $eventAssistant = EventAssistant::firstOrCreate(
            [
                'event_id' => $event->id,
                'user_id' => $user->id,
            ],
            [
                'ticket_type_id' => $coupon->ticket_type_id ?? null,
                'has_entered' => true,
                'is_paid' => true,
                'guardian_id' => $guardianId,
            ]
        );

        // Obtener los parámetros adicionales definidos para el evento
        $definedParameters = AdditionalParameter::where('event_id', $event->id)->get();
        // Obtener las columnas definidas en $fillable del modelo User
        $userFillableColumns = (new User())->getFillable();
        // Detectar y almacenar parámetros adicionales enviados en el registro
        $additionalParameters = $request->except(array_merge(['_token'], $userFillableColumns)); // Excluir columnas del modelo User

        foreach ($definedParameters as $definedParameter) {
            if (isset($additionalParameters[$definedParameter->name])) {
                UserEventParameter::create([
                    'event_id' => $event->id,
                    'user_id' => $user->id,
                    'additional_parameter_id' => $definedParameter->id,
                    'value' => $additionalParameters[$definedParameter->name],
                ]);
            }
        }
        $coupon->is_consumed = true;
        $coupon->event_assistant_id = $eventAssistant->id;
        $coupon->save();

        return redirect()->back()
        ->with('success', 'Inscripción exitosa.');
    }

    public function checkCourtesyCode($eventId, $code)
    {
        // Busca si el código de cortesía existe en la base de datos
        $coupon = Coupon::where('numeric_code', $code)
            ->where('event_id', $eventId)
            ->where('is_consumed', false)
            ->with('ticketType') // Asegura la relación con ticketType
            ->first();

        // Retorna solo la información del ticketType si el cupón existe
        if ($coupon && $coupon->ticketType) {
            return response()->json(['exists' => true, 'ticket_type' => $coupon->ticketType]);
        } else {
            return response()->json(['exists' => false, 'message' => 'CUPON NO VALIDO']);
        }
    }
    public function destroy($id)
    {
        // Buscar el cupón por ID
        $coupon = Coupon::findOrFail($id);

        // Verificar si el cupón ya ha sido consumido
        if ($coupon->is_consumed) {
            return redirect()->back()->withErrors('No se puede eliminar el cupón porque ya ha sido consumido.');
        }
        // Eliminar el cupón si no ha sido consumido
        $coupon->delete();

        // Redirigir con un mensaje de éxito
        return redirect()->route('coupons.index', ['idEvent' => $coupon->event_id])->with('success', 'Cupón eliminado exitosamente.');
    }

    public function generateExcel($idEvent){
        $event = Event::find($idEvent);
        return Excel::download(
            new CouponExport($idEvent),
            'pagos_de_asistentes_del_evento_'.$event->name.'_'.date('d-m-Y').'.xlsx'
        );
    }
}
