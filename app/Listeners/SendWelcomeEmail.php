<?php

namespace App\Listeners;

use App\Mail\WelcomeMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail implements ShouldQueue
{
    public function handle(Registered $event): void
    {
        $cacheKey = sprintf('mail:welcome:%s', $event->user->id);

        if (! Cache::add($cacheKey, true, now()->addDay())) {
            return;
        }

        Mail::send(new WelcomeMail($event->user));
    }
}
