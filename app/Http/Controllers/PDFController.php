<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\EventAssistant;
use App\Models\TicketType;
use App\Models\TicketFeatures;
use App\Models\Event;
use App\Models\City;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketNotification;
use Pdf;

class PDFController extends Controller
{
    public function getPDF(){

		
		$name = 'Juanito Perez';
		$pdf = Pdf::loadView('pdf.PDF_TicketEvento', compact('name'));
		return $pdf->stream('prueba.pdf');
	}

	public function getPDFEvento($id){
        
		$assistant=EventAssistant::find($id);
		$user=User::find($assistant->user_id);
		$event=event::find($assistant->event_id);
		$pdf = Pdf::loadView('pdf.PDF_TicketEvento', compact('user','event'));
		$pdf->setPaper(array(0,0,170,450));
		$pdf->save(storage_path('app/public/' . $event->name.'.pdf'));
		return $pdf->stream($event->name.'.pdf');
		
		
	}

	public function getPDFEventoQuery($id){
        
		$query=EventAssistant::select('events.id','events.name as evento_name','events.header_image_path',
		'events.created_at','events.event_date','events.start_time','users.id','users.name',
		'users.lastname','users.type_document','users.document_number','event_assistant.qrCode',
		'event_assistant.guid','ticket_types.name as localidad','event_assistant.has_entered')
		->join('events','events.id','=','event_assistant.event_id')
		->join('users','users.id','=','event_assistant.user_id')
		->join('ticket_types','ticket_types.id','=','event_assistant.ticket_type_id')
		->where('users.id',$id);


		return $query->get();
		
		
		
	}

	public function buildPDF($id)
	{
	    $registros=$this->getPDFEventoQuery($id);
		foreach ($registros as &$registro) {
			
			$pdf = Pdf::loadView('pdf.pdf_example', compact('registros'));
		    $pdf->setPaper(array(0,0,170,450));
		    $pdf->save(storage_path('app/public/'.$registro->evento_name.'.pdf'));
			return $pdf->stream($registro->evento_name.'.pdf');
		}
		
		
		
	}
	
}
