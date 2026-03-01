<?php

namespace Tests\Feature;

use App\Actions\Enrollment\EnrollUserInCourseAction;
use App\Actions\Progress\CompleteLessonAction;
use App\Actions\Progress\EnsureCourseCompletionAction;
use App\Mail\CourseCompletedMail;
use App\Mail\WelcomeMail;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\CourseCompletion;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class EnrollmentFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_queues_welcome_email(): void
    {
        Mail::fake();

        $this->post('/register', [
            'name' => 'Learner',
            'email' => 'learner@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ])->assertRedirect('/');

        Mail::assertSent(WelcomeMail::class, 1);
    }

    public function test_enrollment_duplication_is_prevented_and_drafts_are_blocked(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $action = app(EnrollUserInCourseAction::class);

        $action->execute($user, $course);
        $action->execute($user, $course);

        $this->assertDatabaseCount('enrollments', 1);

        $draftCourse = Course::factory()->draft()->create();

        $this->actingAs($user)
            ->post(route('courses.enroll', $draftCourse->slug))
            ->assertNotFound();
    }

    public function test_completion_sends_one_email_and_creates_one_certificate(): void
    {
        Mail::fake();

        $user = User::factory()->create();
        $course = Course::factory()->create();
        $lessonA = Lesson::factory()->for($course)->create(['position' => 1]);
        $lessonB = Lesson::factory()->for($course)->create(['position' => 2]);

        Enrollment::query()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);

        $action = app(CompleteLessonAction::class);

        $action->execute($user, $lessonA);
        $action->execute($user, $lessonA);

        $this->assertDatabaseCount('course_completions', 0);
        $this->assertDatabaseCount('certificates', 0);

        $action->execute($user, $lessonB);
        $action->execute($user, $lessonB);

        $this->assertDatabaseCount('course_completions', 1);
        $this->assertDatabaseCount('certificates', 1);
        $this->assertTrue(CourseCompletion::query()->where('user_id', $user->id)->where('course_id', $course->id)->exists());
        $this->assertTrue(Certificate::query()->where('user_id', $user->id)->where('course_id', $course->id)->exists());
        Mail::assertSent(CourseCompletedMail::class, 1);
    }

    public function test_slug_remains_unique_around_soft_deletes(): void
    {
        $course = Course::factory()->create([
            'slug' => 'career-essentials',
        ]);

        $course->delete();

        $replacement = Course::factory()->create([
            'slug' => 'career-essentials',
        ]);

        $this->assertSame('career-essentials', $replacement->slug);
        $this->assertStringContainsString(
            '--archived-',
            Course::withTrashed()->findOrFail($course->id)->slug,
        );
    }

    public function test_non_preview_lessons_are_isolated_to_enrolled_users_only(): void
    {
        $course = Course::factory()->create();
        $lesson = Lesson::factory()->for($course)->create([
            'is_preview' => false,
        ]);
        $enrolledUser = User::factory()->create();
        $otherUser = User::factory()->create();

        Enrollment::query()->create([
            'user_id' => $enrolledUser->id,
            'course_id' => $course->id,
        ]);

        $this->get(route('lessons.show', ['slug' => $course->slug, 'lesson' => $lesson->id]))
            ->assertForbidden();

        $this->actingAs($otherUser)
            ->get(route('lessons.show', ['slug' => $course->slug, 'lesson' => $lesson->id]))
            ->assertForbidden();

        $this->actingAs($enrolledUser)
            ->get(route('lessons.show', ['slug' => $course->slug, 'lesson' => $lesson->id]))
            ->assertOk();
    }

    public function test_completion_is_revoked_if_a_new_required_lesson_is_added_later(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $initialLesson = Lesson::factory()->for($course)->create(['position' => 1]);

        Enrollment::query()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);

        app(CompleteLessonAction::class)->execute($user, $initialLesson);

        $this->assertDatabaseCount('course_completions', 1);
        $this->assertDatabaseCount('certificates', 1);

        $newLesson = Lesson::factory()->for($course)->create(['position' => 2]);

        app(EnsureCourseCompletionAction::class)->execute($user, $course->fresh());

        $this->assertDatabaseCount('course_completions', 0);
        $this->assertDatabaseCount('certificates', 0);

        app(CompleteLessonAction::class)->execute($user, $newLesson);

        $this->assertDatabaseCount('course_completions', 1);
        $this->assertDatabaseCount('certificates', 1);
    }
}
