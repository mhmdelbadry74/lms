<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->firstOrCreate(
            ['email' => 'demo@example.com'],
            [
                'name' => 'Demo User',
                'password' => 'password',
            ],
        );

        $course = Course::query()->firstOrCreate(
            ['slug' => 'laravel-foundations'],
            [
                'title' => 'Laravel Foundations',
                'image_path' => 'https://placehold.co/640x360?text=Laravel+Foundations',
                'level' => 'Beginner',
                'status' => 'published',
            ],
        );

        Lesson::query()->firstOrCreate(
            [
                'course_id' => $course->id,
                'position' => 1,
            ],
            [
                'title' => 'Welcome and Setup',
                'is_preview' => true,
                'is_required' => true,
            ],
        );

        Lesson::query()->firstOrCreate(
            [
                'course_id' => $course->id,
                'position' => 2,
            ],
            [
                'title' => 'Enrollment and Progress',
                'is_preview' => false,
                'is_required' => true,
            ],
        );
    }
}
