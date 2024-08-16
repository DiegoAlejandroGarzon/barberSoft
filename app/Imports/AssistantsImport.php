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
    protected $importedUsers = [];
    protected $messages = [];

    public function __construct($eventId)
    {
        $this->eventId = $eventId;
    }

    public function model(array $row)
    {
        try {
            $user = User::firstOrCreate(
                ['email' => $row['email']],
                [
                    'name' => $row['name'],
                    'lastname' => $row['lastname'] ?? null,
                    'password' => bcrypt('12345678'),
                    'status' => true,
                    'phone' => $row['phone'] ?? null,
                    'type_document' => $row['type_document'] ?? null,
                    'document_number' => $row['document_number'] ?? null,
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
                throw new Exception("Ticket type '{$row['ticket_type']}' not found for event ID {$this->eventId}");
            }

            // Verificar si ya existe una asignación para este usuario y este tipo de ticket
            $eventAssistant = EventAssistant::where('event_id', $this->eventId)
            ->where('user_id', $user->id)
            ->first();

            if ($eventAssistant) {
                // Si ya existe, actualiza la información del EventAssistant si es necesario
                $eventAssistant->update([
                    'ticket_type_id' => $ticketType->id,
                ]);
            } else {
                // Si no existe, crea un nuevo registro
                $eventAssistant = EventAssistant::create([
                    'event_id' => $this->eventId,
                    'user_id' => $user->id,
                    'ticket_type_id' => $ticketType->id,
                ]);
            }

            $eventAssistant->save();

            // Añadir usuario a la lista de importados
            $this->importedUsers[] = [
                'user' => $user,
                'ticket_type' => $ticketType->name,
            ];
        } catch (Exception $e) {
            // Guardar el mensaje de error
            $this->messages[] = "Error con usuario {$row['email']}: " . $e->getMessage();
        }
    }

    public function getImportedUsers()
    {
        return $this->importedUsers;
    }

    public function getMessages()
    {
        return $this->messages;
    }
}
