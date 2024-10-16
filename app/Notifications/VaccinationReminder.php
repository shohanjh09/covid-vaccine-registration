<?php

namespace App\Notifications;

use App\Models\Vaccination;
use App\Models\VaccinationCenter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class VaccinationReminder extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The vaccination instance.
     *
     * @var Vaccination
     */
    protected Vaccination $vaccination;

    /**
     * The vaccination center instance.
     *
     * @var VaccinationCenter
     */
    protected VaccinationCenter $vaccineCenter;

    /**
     * Create a new notification instance.
     *
     * @param Vaccination $vaccination
     * @return void
     */
    public function __construct(Vaccination $vaccination, VaccinationCenter $vaccineCenter)
    {
        $this->vaccination = $vaccination;
        $this->vaccineCenter = $vaccineCenter;
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
            $channels[] = 'twilio';
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
        Log::info("Sending vaccination reminder email to user: {$notifiable->id}, email: {$notifiable->email}, and scheduled for {$this->vaccination->scheduled_date} at {$this->vaccineCenter->name}");

        return (new MailMessage)
            ->subject('Vaccination Reminder: Your Appointment is Scheduled')
            ->view('emails.vaccination-reminder', [
                'name' => $notifiable->name,
                'scheduledDate' => $this->vaccination->scheduled_date,
                'vaccineCenterName' => $this->vaccineCenter->name,
            ]);
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
