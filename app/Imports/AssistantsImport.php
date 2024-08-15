<?php

namespace App\Imports;

use App\Models\User;
use App\Models\EventAssistant;
use App\Models\TicketType;
use Exception;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AssistantsImport implements ToModel, WithHeadingRow
{
    protected $eventId;

    public function __construct($eventId)
    {
        $this->eventId = $eventId;
    }

    public function model(array $row)
    {
        $user = User::firstOrCreate(
            ['email' => $row['email']],
            [
                'name' => $row['name'],
                'lastname' => $row['lastname'] ?? null,  // Asignar apellido si está disponible en la fila
                'password' => bcrypt('12345678'),  // Asignar la contraseña predeterminada
                'status' => true,  // Asignar el estado como activo
                'phone' => $row['phone'] ?? null,  // Asignar teléfono si está disponible en la fila
                'type_document' => $row['type_document'] ?? null,  // Asignar tipo de documento si está disponible
                'document_number' => $row['document_number'] ?? null,  // Asignar número de documento si está disponible
            ]
        );

        // Asignar el rol "Assistant" al usuario
        if (!$user->hasRole('Assistant')) {
            $user->assignRole('Assistant');
        }

        // Buscar el tipo de ticket por nombre y event_id
        $ticketType = TicketType::where('event_id', $this->eventId)
                                ->where('name', $row['ticket_type'])
                                ->first();

        if (!$ticketType) {
            // Si no se encuentra el tipo de ticket, lanzar una excepción
            throw new Exception("Ticket type '{$row['ticket_type']}' not found for event ID {$this->eventId}");
        }

        return new EventAssistant([
            'event_id' => $this->eventId,
            'user_id' => $user->id,
            'ticket_type_id' => $ticketType->id, // Asignar el ID del tipo de ticket
        ]);
    }
}
