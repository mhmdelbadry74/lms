<?php

namespace App\Livewire\Lessons;

use App\Models\Lesson;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShowLesson extends Component
{
    public string $slug;
    public string $lessonId;

    public function mount(string $slug, string $lesson): void
    {
        $this->slug = $slug;
        $this->lessonId = $lesson;
    }

    public function render()
    {
        $lesson = Lesson::query()
            ->with(['course', 'course.enrollments'])
            ->findOrFail($this->lessonId);

        abort_unless($lesson->course->slug === $this->slug, 404);
        Gate::authorize('view', $lesson);

        $userId = auth()->id();
        $completedRequiredLessons = $userId === null
            ? 0
            : $lesson->course->requiredLessons()
                ->whereHas('progress', function ($query) use ($userId): void {
                    $query->where('user_id', $userId)->whereNotNull('completed_at');
                })
                ->count();
        $requiredLessons = max(1, $lesson->course->requiredLessons()->count());
        $progressPercent = (int) floor(($completedRequiredLessons / $requiredLessons) * 100);

        return view('livewire.lessons.show-lesson', [
            'lesson' => $lesson,
            'course' => $lesson->course,
            'progressPercent' => $progressPercent,
        ])->layout('layouts.app');
    }
}
