<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected static function booted(): void
    {
        static::deleting(function (Course $course): void {
            if ($course->isForceDeleting() || str_contains($course->slug, '--archived-')) {
                return;
            }

            $course->slug = $course->slug.'--archived-'.Str::lower((string) Str::ulid());
            $course->saveQuietly();
        });
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function completions(): HasMany
    {
        return $this->hasMany(CourseCompletion::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function requiredLessons(): HasMany
    {
        return $this->lessons()->where('is_required', true);
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
