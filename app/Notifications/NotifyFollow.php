<?php

namespace App\Notifications;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyFollow extends Notification
{
    use Queueable;
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

   
    public function via($notifiable)
    {
        return ['database','broadcast'];
    }

    public function toBroadcast($notifiable)
    {
       

        return new BroadcastMessage([
            'date' => Carbon::now(),
            'message' => 'Comenzo a seguirte!',
            'user' => $this->user,
        ]);
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Comenzo a seguirte!',
            'user' => $this->user,
        ];
    }
}
