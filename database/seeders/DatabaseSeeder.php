<?php

namespace Database\Seeders;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\CourseCompletion;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $demoUser = User::query()->updateOrCreate(
            ['email' => 'demo@example.com'],
            [
                'name' => 'Demo User',
                'password' => 'password',
            ],
        );

        $completedUser = User::query()->updateOrCreate(
            ['email' => 'completed@example.com'],
            [
                'name' => 'Completed Learner',
                'password' => 'password',
            ],
        );

        $partialUser = User::query()->updateOrCreate(
            ['email' => 'partial@example.com'],
            [
                'name' => 'Partial Learner',
                'password' => 'password',
            ],
        );

        $foundations = Course::query()->updateOrCreate(
            ['slug' => 'laravel-foundations'],
            [
                'title' => 'Laravel Foundations',
                'image_path' => 'https://placehold.co/640x360?text=Laravel+Foundations',
                'level' => 'Beginner',
                'status' => 'published',
            ],
        );

        $this->upsertLesson($foundations, 1, 'Welcome and Setup', true, true);
        $this->upsertLesson($foundations, 2, 'Enrollment Integrity', false, true);
        $this->upsertLesson($foundations, 3, 'Progress and Certificates', false, true);
        $this->upsertLesson($foundations, 4, 'Optional Refactoring Notes', false, false);

        $scaling = Course::query()->updateOrCreate(
            ['slug' => 'concurrency-blueprint'],
            [
                'title' => 'Concurrency Blueprint',
                'image_path' => 'https://placehold.co/640x360?text=Concurrency+Blueprint',
                'level' => 'Advanced',
                'status' => 'published',
            ],
        );

        $this->upsertLesson($scaling, 1, 'Previewing the Problem Space', true, true);
        $this->upsertLesson($scaling, 2, 'Database Constraints First', false, true);
        $this->upsertLesson($scaling, 3, 'Transactions and Retries', false, true);
        $this->upsertLesson($scaling, 4, 'Queue Idempotency', false, true);
        $this->upsertLesson($scaling, 5, 'Optional Operations Checklist', false, false);

        $uxCourse = Course::query()->updateOrCreate(
            ['slug' => 'interactive-lesson-ux'],
            [
                'title' => 'Interactive Lesson UX',
                'image_path' => 'https://placehold.co/640x360?text=Interactive+Lesson+UX',
                'level' => 'Intermediate',
                'status' => 'published',
            ],
        );

        $this->upsertLesson($uxCourse, 1, 'Accordion Lesson Map', true, true);
        $this->upsertLesson($uxCourse, 2, 'Completion Confirmation', false, true);
        $this->upsertLesson($uxCourse, 3, 'Progress Animations', false, false);

        Course::query()->updateOrCreate(
            ['slug' => 'draft-internal-syllabus'],
            [
                'title' => 'Draft Internal Syllabus',
                'image_path' => 'https://placehold.co/640x360?text=Draft+Only',
                'level' => 'Internal',
                'status' => 'draft',
            ],
        );

        $this->seedEnrollmentState($demoUser, $foundations, [1, 2], false);
        $this->seedEnrollmentState($demoUser, $scaling, [1, 2, 3, 4], true);
        $this->seedEnrollmentState($demoUser, $uxCourse, [1], false);
        $this->seedEnrollmentState($partialUser, $scaling, [1, 2], false);
        $this->seedEnrollmentState($completedUser, $scaling, [1, 2, 3, 4], true);
        $this->seedEnrollmentState($completedUser, $uxCourse, [1, 2], true);
    }

    private function upsertLesson(Course $course, int $position, string $title, bool $isPreview, bool $isRequired): Lesson
    {
        return Lesson::query()->updateOrCreate(
            [
                'course_id' => $course->id,
                'position' => $position,
            ],
            [
                'title' => $title,
                'is_preview' => $isPreview,
                'is_required' => $isRequired,
            ],
        );
    }

    /**
     * @param array<int> $completedPositions
     */
    private function seedEnrollmentState(User $user, Course $course, array $completedPositions, bool $markCourseComplete): void
    {
        Enrollment::query()->firstOrCreate([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);

        $lessons = $course->lessons()->get()->keyBy('position');

        foreach ($completedPositions as $position) {
            /** @var Lesson|null $lesson */
            $lesson = $lessons->get($position);

            if ($lesson === null) {
                continue;
            }

            LessonProgress::query()->updateOrCreate(
                [
                    'user_id' => $user->id,
                    'lesson_id' => $lesson->id,
                ],
                [
                    'started_at' => now()->subDays(2)->addMinutes($position * 7),
                    'completed_at' => now()->subDays(1)->addMinutes($position * 9),
                ],
            );
        }

        if (! $markCourseComplete) {
            CourseCompletion::query()
                ->where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->delete();

            Certificate::query()
                ->where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->delete();

            return;
        }

        CourseCompletion::query()->firstOrCreate(
            [
                'user_id' => $user->id,
                'course_id' => $course->id,
            ],
            [
                'completed_at' => now()->subHours(12),
            ],
        );

        Certificate::query()->firstOrCreate(
            [
                'user_id' => $user->id,
                'course_id' => $course->id,
            ],
            [
                'uuid' => (string) Str::uuid(),
            ],
        );
    }
}
