<?php

namespace App\Notifications;

use App\Temperature;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TemperatureAlert extends Notification implements ShouldQueue
{
    use Queueable;

    public $temperature;
    public $name;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Temperature $temperature)
    {
        $this->temperature = $temperature->temperature . ' °' . $temperature->scale;
        $this->name = $temperature->user->name;
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
        return (new MailMessage)
                    ->subject('High Temperature Alert')
                    ->greeting('Temperature alert!')
                    ->line($this->name . ' is running a high temperature of ' . $this->temperature);
    }
}
