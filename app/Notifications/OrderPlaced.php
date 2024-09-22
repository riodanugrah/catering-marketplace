<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPlaced extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('You have a new order.')
            ->action('View Order', url('/merchant/orders'))
            ->line('Thank you for using our application!');

        // ->greeting('Hello, ' . $notifiable->name)
        //     ->line('You have a new order.')
        //     ->line('Order ID: ' . $this->order->id)
        //     ->line('Menu: ' . $this->order->menu->name)
        //     ->line('Quantity: ' . $this->order->quantity)
        //     ->action('View Order', url('/merchant/orders'))
        //     ->line('Thank you for using our service!');
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
        ];
    }
}
