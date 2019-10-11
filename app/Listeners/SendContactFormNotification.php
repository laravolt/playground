<?php

namespace App\Listeners;

use App\Events\ContactFormSubmitted;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendContactFormNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ContactFormSubmitted $event
     * @return void
     */
    public function handle(ContactFormSubmitted $event)
    {
        $notification = new \App\Notifications\ContactFormSubmitted($event->contactForm);

        // 1. Kirim ke admin
        $admin = User::first();
        $admin->notify($notification);

        // 2. Kirim ke email yang bsersangkutan
        Notification::route('mail', $event->contactForm->email)->notify($notification);
    }
}
