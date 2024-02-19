<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProduitRupture extends Notification
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
                    ->from('laraveljym@gmail.com')
                    ->line('Bonjour cher administrateur, votre produit est en niveau de stock critique. Veuillez penser à vous approvisionner.')
                    ->action('Retrouvez plus d\'informations , concernant votre niveau de stock', url('/categorie/list'))
                    ->greeting('Merci pour votre commande, ' . $notifiable->name . '!')
                    ->line('Merci pour votre attention!'); 
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
