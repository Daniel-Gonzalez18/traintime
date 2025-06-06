<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class VerificarEmailPersonalizado extends VerifyEmail
{
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Confirma tu correo')
            ->greeting('¡Hola ' . $notifiable->name . '!')
            ->line('Gracias por registrarte. Por favor confirma tu dirección de correo.')
            ->action('Verificar Email', $verificationUrl)
            ->line('Si no solicitaste esta cuenta, ignora este mensaje.');
    }
}
