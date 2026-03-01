<?php

namespace App\Actions\Progress;

use App\Events\CourseCompleted;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\CourseCompletion;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EnsureCourseCompletionAction
{
    public function execute(User $user, Course $course): ?CourseCompletion
    {
        $requiredLessons = $course->lessons()->where('is_required', true)->count();
        $completedRequiredLessons = $course->lessons()
            ->where('is_required', true)
            ->whereHas('progress', function ($query) use ($user): void {
                $query->where('user_id', $user->id)->whereNotNull('completed_at');
            })
            ->count();

        $existing = CourseCompletion::query()
            ->where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        $isComplete = $requiredLessons > 0 && $requiredLessons === $completedRequiredLessons;

        if (! $isComplete) {
            if ($existing !== null) {
                DB::transaction(function () use ($existing, $user, $course): void {
                    $existing->delete();

                    Certificate::query()
                        ->where('user_id', $user->id)
                        ->where('course_id', $course->id)
                        ->delete();
                });
            }

            return null;
        }

        if ($existing !== null) {
            return $existing;
        }

        return DB::transaction(function () use ($user, $course): CourseCompletion {
            $completion = CourseCompletion::firstOrCreate([
                'user_id' => $user->id,
                'course_id' => $course->id,
            ]);

            Certificate::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'course_id' => $course->id,
                ],
                [
                    'uuid' => (string) Str::uuid(),
                ],
            );

            if ($completion->wasRecentlyCreated) {
                DB::afterCommit(function () use ($user, $course): void {
                    CourseCompleted::dispatch($user, $course);
                });
            }

            return $completion;
        });
    }
}
