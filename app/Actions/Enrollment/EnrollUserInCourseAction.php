<?php

namespace App\Actions\Enrollment;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class EnrollUserInCourseAction
{
    public function execute(User $user, Course $course): Enrollment
    {
        return DB::transaction(function () use ($user, $course): Enrollment {
            abort_unless($course->isPublished(), 404);

            return Enrollment::firstOrCreate([
                'user_id' => $user->id,
                'course_id' => $course->id,
            ]);
        });
    }
}
