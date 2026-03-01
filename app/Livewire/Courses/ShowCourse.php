<?php

namespace App\Livewire\Courses;

use App\Models\Course;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShowCourse extends Component
{
    public string $slug;

    public function mount(string $slug): void
    {
        $this->slug = $slug;
    }

    public function render()
    {
        $course = Course::query()
            ->where('slug', $this->slug)
            ->with([
                'lessons' => fn ($query) => $query->orderBy('position'),
                'enrollments',
            ])
            ->firstOrFail();

        Gate::authorize('view', $course);

        return view('livewire.courses.show-course', [
            'course' => $course,
        ])->layout('layouts.app');
    }
}
