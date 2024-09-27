<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class InvoicePaid extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        //
      $this->order=$order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)->markdown('mail.invoice.paid');
    }


    /**
     * Get the notification's database type.
     *
     * @return string
     */
    public function databaseType(object $notifiable): string
    {
        return 'invoice-paid';
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
                'Fecha Compra' => $this->order->created_at,
                'nombres'=>$this->order->nombres,
                'apellidos'=>$this->order->apellidos,
                'cedula'=>$this->order->cedula,
                'telefono'=>$this->order->telefono,
                'reference_number'=>$this->order->reference_number,
                'description'=>$this->order->description,
                'precio'=>$this->order->precio,
                'status'=>$this->order->status,
           
        ];
    }
}
