<?php

namespace App\Providers;

use App\Events\CourseCompleted;
use App\Listeners\SendCourseCompletedEmail;
use App\Listeners\SendWelcomeEmail;
use App\Models\Course;
use App\Models\Lesson;
use App\Policies\CoursePolicy;
use App\Policies\LessonPolicy;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        Gate::policy(Course::class, CoursePolicy::class);
        Gate::policy(Lesson::class, LessonPolicy::class);

        Event::listen(Registered::class, SendWelcomeEmail::class);
        Event::listen(CourseCompleted::class, SendCourseCompletedEmail::class);
    }
}
