<?php

namespace App\Livewire\Public;

use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;

class Home extends Component
{
    use WithPagination;

    public function render()
    {
        $courses = Course::query()
            ->where('status', 'published')
            ->withCount('lessons')
            ->orderBy('title')
            ->paginate(12);

        return view('livewire.public.home', [
            'courses' => $courses,
        ])->layout('layouts.app');
    }
}
