<?php

namespace App\Notifications;

use App\Enum\Status;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    protected Order $order;
    protected Status $oldStatus;

    public function __construct($order, $oldStatus)
    {
        $this->order = $order;
        $this->oldStatus = $oldStatus;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Order Status Updated')
            ->greeting('Hello!')
            ->line("The status of your order #{$this->order->id} has been updated.")
            ->line("Old Status: {$this->oldStatus->value}")
            ->line("New Status: {$this->order->status->value}")
            ->action('View Order', url("/orders/{$this->order->id}"))
            ->line('Thank you for using our application!');
    }
}
