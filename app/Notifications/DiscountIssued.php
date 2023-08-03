<?php

namespace App\Notifications;

use App\Models\Discount;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DiscountIssued extends Notification implements ShouldQueue
{
    use Queueable;
    protected $discount;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Discount $discount)
    {
        $this->discount = $discount;
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
                    ->subject('Tavs atlaides kods Aristotelim')
                    ->greeting('Tavs atlaižu kods Aristoteļa vakara daļas biļetei')
                    ->line($this->discount->code)
                    ->action('Pirkt biļeti', env('TICKET_LINK'))
                    ->line('Jautājumu vai neskaidrību gadījumā raksti uz aristotelis@lusp.lv')
                    ->replyTo('aristotelis@lusp.lv');
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
