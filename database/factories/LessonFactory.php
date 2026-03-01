<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lesson>
 */
class LessonFactory extends Factory
{
    protected $model = Lesson::class;

    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),
            'title' => fake()->sentence(4),
            'position' => fake()->numberBetween(1, 10),
            'is_preview' => false,
            'is_required' => true,
        ];
    }

    public function preview(): static
    {
        return $this->state(fn (): array => [
            'is_preview' => true,
        ]);
    }

    public function optional(): static
    {
        return $this->state(fn (): array => [
            'is_required' => false,
        ]);
    }
}
