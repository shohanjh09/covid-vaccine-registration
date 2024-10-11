<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Twilio\TwilioMessage;
use App\Models\Vaccination;

class VaccinationReminder extends Notification implements ShouldQueue
{
    use Queueable;

    protected Vaccination $vaccination;

    /**
     * Create a new notification instance.
     *
     * @param Vaccination $vaccination
     * @return void
     */
    public function __construct(Vaccination $vaccination)
    {
        $this->vaccination = $vaccination;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $channels = ['mail'];

        if ($notifiable->phone_number) {
            $channels[] = 'twilio';  // Use Twilio for SMS notifications
        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->view('emails.vaccination-reminder', [
                'user' => $notifiable,
                'vaccination' => $this->vaccination,
            ]);
    }

    /**
     * Get the Twilio / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return TwilioMessage
     */
    public function toTwilio($notifiable)
    {
        return (new TwilioMessage())
            ->content('Reminder: Your COVID-19 vaccination is scheduled for ' . $this->vaccination->scheduled_date . ' at ' . $this->vaccination->vaccineCenter->name . '. Please bring your NID.');
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
            'vaccination_id' => $this->vaccination->id,
            'scheduled_date' => $this->vaccination->scheduled_date,
        ];
    }
}
