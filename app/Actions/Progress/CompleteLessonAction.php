<?php

namespace App\Actions\Progress;

use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CompleteLessonAction
{
    public function __construct(
        private readonly EnsureCourseCompletionAction $ensureCourseCompletion,
    ) {
    }

    public function execute(User $user, Lesson $lesson): LessonProgress
    {
        return DB::transaction(function () use ($user, $lesson): LessonProgress {
            abort_unless($lesson->course->isPublished(), 404);

            $isEnrolled = Enrollment::query()
                ->where('user_id', $user->id)
                ->where('course_id', $lesson->course_id)
                ->exists();

            abort_unless($isEnrolled, 403);

            $progress = LessonProgress::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'lesson_id' => $lesson->id,
                ],
                [
                    'started_at' => Carbon::now(),
                    'completed_at' => Carbon::now(),
                ],
            );

            if ($progress->completed_at === null) {
                $progress->forceFill([
                    'started_at' => $progress->started_at ?? Carbon::now(),
                    'completed_at' => Carbon::now(),
                ])->save();
            }

            $this->ensureCourseCompletion->execute($user, $lesson->course);

            return $progress->refresh();
        });
    }
}
