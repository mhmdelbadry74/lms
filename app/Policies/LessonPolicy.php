<?php

namespace App\Policies;

use App\Models\Lesson;
use App\Models\User;

class LessonPolicy
{
    public function view(?User $user, Lesson $lesson): bool
    {
        if (! $lesson->course->isPublished()) {
            return false;
        }

        if ($lesson->is_preview) {
            return true;
        }

        if ($user === null) {
            return false;
        }

        return $lesson->course
            ->enrollments()
            ->where('user_id', $user->id)
            ->exists();
    }

    public function complete(User $user, Lesson $lesson): bool
    {
        if (! $lesson->course->isPublished()) {
            return false;
        }

        return $lesson->course
            ->enrollments()
            ->where('user_id', $user->id)
            ->exists();
    }
}
