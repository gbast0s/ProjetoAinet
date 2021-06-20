<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Fatura extends Notification
{
    use Queueable;

    private $fatura;
    public function __construct($fatura)
    {
        $this->fatura = $fatura;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url('/faturas/'.$this->fatura);
        $path = storage_path('app/pdf_recibos/' .$this->fatura);

        return (new MailMessage)
            ->greeting('Olá')
            ->line('Uma das tuas encomendas foi finalizada')
            ->line('Podes ver a fatura online')
            ->action('Ver Fatura', $url)
            ->line('O ficheiro vem ainda anexado a este email')
            ->line('Obrigado por comprares na MagicShirts!')
            ->attach($path);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
