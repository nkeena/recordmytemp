<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class RecordMissing extends Notification implements ShouldQueue
{
    use Queueable;

    public $people;
    public $log;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $people, string $log)
    {
        $this->people = $people;
        $this->log = $log;
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
        $mail = (new MailMessage)
                    ->subject("{$this->log} - Missing Temperature(s)")
                    ->greeting('Missing temperature(s)')
                    ->line("It looks like the following people missed a temperature recording today for {$this->log}. You might want to check in with them.");

        foreach ($this->people as $person) {
            $mail->line("- {$person}");
        }

        return $mail;
    }
}
