<?php

namespace App\Listeners;

use App\Events\CourseCompleted;
use App\Mail\CourseCompletedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class SendCourseCompletedEmail implements ShouldQueue
{
    public function handle(CourseCompleted $event): void
    {
        $cacheKey = sprintf(
            'mail:course-completed:%s:%s',
            $event->user->id,
            $event->course->id,
        );

        if (! Cache::add($cacheKey, true, now()->addDay())) {
            return;
        }

        Mail::send(new CourseCompletedMail($event->user, $event->course));
    }
}
