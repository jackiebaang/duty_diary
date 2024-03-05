<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class NewDiaryPosted extends Notification
{
    use Queueable;

    public $diary;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($diary)
    {
        $this->diary = $diary;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toSlack($notifiable)
    {
        // $content = $this->diary['trainee'] . ' has posted a duty diary and assigned to supervisor ' . $this->diary['supervisor'] . ' for Approval.' ."\n [" . $this->diary['url'] . ']';
        // $content = $this->diary['trainee'] . ' has posted a duty diary and assigned to supervisor ' . $this->diary['supervisor'] . ' for Approval.' ."\n [" . $this->diary['url'] . ']';
        // $htmlContent = '<p>' . $content . '</p>' . $this->diary['content'];

        // $content = $this->diary['trainee'] . ' has posted a duty diary and assigned to supervisor ' . $this->diary['supervisor'] . ' for Approval.' . "\n<" . $this->diary['url'] . '|View Diary>';
        $message = "*{$this->diary['trainee']}* has posted a duty diary and assigned it to supervisor *{$this->diary['supervisor']}* for Approval.\n<{$this->diary['url']}|View Diary>\n".$this->diary['content'];
        
        return (new SlackMessage)->content($message);
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
