<div style="display:grid; gap:1.5rem;">
    <div class="panel" style="overflow:hidden;">
        @if ($course->image_path)
            <img src="{{ $course->image_path }}" alt="{{ $course->title }}" style="display:block; width:100%; max-height:22rem; object-fit:cover;">
        @endif
        <div style="padding:1.5rem;">
            <div style="display:flex; align-items:center; gap:0.75rem; flex-wrap:wrap;">
                <span class="badge badge-brand">{{ $course->level }}</span>
                <span class="badge badge-success">{{ $course->status }}</span>
                <span class="badge" style="background:rgba(15,118,110,0.08); color:var(--brand-strong);">{{ $course->lessons->count() }} lessons</span>
            </div>
            <h1 style="margin:0.9rem 0 0; font-size:2.1rem;">{{ $course->title }}</h1>
            <p class="muted" style="margin:0.75rem 0 0;">Track lessons, enroll once, and keep completion state logically consistent even if the curriculum changes later.</p>

            <div class="grid-auto" style="margin-top:1.25rem;">
                <div class="metric">
                    <strong>{{ $course->requiredLessons()->count() }}</strong>
                    <span class="muted">Required lessons</span>
                </div>
                <div class="metric">
                    <strong>{{ $course->lessons->where('is_preview', true)->count() }}</strong>
                    <span class="muted">Preview lessons</span>
                </div>
                <div class="metric">
                    <strong>{{ $course->lessons->where('is_required', false)->count() }}</strong>
                    <span class="muted">Optional lessons</span>
                </div>
            </div>

            <div style="margin-top:1.15rem;">
                @auth
                    @if ($course->enrollments->where('user_id', auth()->id())->isNotEmpty())
                        <p class="badge badge-success">Enrolled</p>
                    @else
                        <form method="POST" action="{{ route('courses.enroll', $course->slug) }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">Enroll</button>
                        </form>
                    @endif
                @else
                    <p class="muted">Sign in to enroll and mark lessons complete.</p>
                @endauth
            </div>
        </div>
    </div>

    <section x-data="{ openLesson: {{ $course->lessons->first()?->id ?? 'null' }} }" class="panel" style="padding:1.25rem;">
        <div style="display:flex; align-items:center; justify-content:space-between; gap:1rem; margin-bottom:1rem;">
            <h2 style="margin:0; font-size:1.2rem;">Lessons</h2>
            <span class="muted">{{ $course->requiredLessons()->count() }} required</span>
        </div>

        @foreach ($course->lessons as $lesson)
            <div style="border-top:1px solid var(--line); padding:0.85rem 0;">
                <button
                    type="button"
                    x-on:click="openLesson = openLesson === {{ $lesson->id }} ? null : {{ $lesson->id }}"
                    style="width:100%; display:flex; align-items:center; justify-content:space-between; gap:1rem; background:none; border:none; padding:0; color:inherit; text-align:left; cursor:pointer;"
                >
                    <div>
                        <p class="muted" style="margin:0; font-size:0.75rem; font-weight:700; letter-spacing:0.08em; text-transform:uppercase;">Lesson {{ $lesson->position }}</p>
                        <h3 style="margin:0.3rem 0 0; font-size:1rem;">{{ $lesson->title }}</h3>
                        @if ($lesson->is_preview)
                            <p class="badge badge-success" style="margin-top:0.5rem;">Preview</p>
                        @endif
                    </div>
                    <span class="muted" x-text="openLesson === {{ $lesson->id }} ? 'Hide' : 'Show'"></span>
                </button>

                <div x-show="openLesson === {{ $lesson->id }}" style="padding-top:0.9rem;">
                    <div class="panel" style="background:var(--panel-muted); padding:1rem; border-radius:1rem;">
                        <p class="muted" style="margin:0 0 0.9rem;">{{ $lesson->is_required ? 'Required lesson' : 'Optional lesson' }}{{ $lesson->is_preview ? ' • Guest preview enabled' : '' }}</p>
                        @if ($lesson->is_preview || auth()->check())
                            <a href="{{ route('lessons.show', ['slug' => $course->slug, 'lesson' => $lesson->id]) }}" class="btn">Open lesson</a>
                        @else
                            <span class="btn" style="opacity:0.6; cursor:not-allowed;">Sign in to continue</span>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </section>
</div>
