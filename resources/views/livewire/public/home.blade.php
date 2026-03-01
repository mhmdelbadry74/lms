<div style="display:grid; gap:1.5rem;">
    <div class="panel" style="padding:1.5rem;">
        <span class="badge badge-brand">Public Home</span>
        <h1 style="margin:0.85rem 0 0; font-size:2.6rem; line-height:1.1;">Published Courses</h1>
        <p class="muted" style="margin:0.75rem 0 0;">Optimized course catalog with eager-loaded lesson counts and reviewer-friendly demo data.</p>
    </div>

    <div style="display:grid; gap:1rem; grid-template-columns:repeat(auto-fit, minmax(18rem, 1fr));">
        @forelse ($courses as $course)
            <a href="{{ route('courses.show', $course->slug) }}" class="panel" style="overflow:hidden;">
                @if ($course->image_path)
                    <img src="{{ $course->image_path }}" alt="{{ $course->title }}" style="display:block; width:100%; aspect-ratio:16/9; object-fit:cover; background:var(--panel-muted);">
                @endif
                <div style="padding:1rem 1rem 1.15rem;">
                    <div style="display:flex; align-items:center; justify-content:space-between; gap:0.75rem;">
                        <span class="badge badge-success">{{ $course->status }}</span>
                        <span class="badge badge-brand">{{ $course->level }}</span>
                    </div>
                    <h2 style="margin:0.9rem 0 0; font-size:1.25rem;">{{ $course->title }}</h2>
                    <p class="muted" style="margin:0.65rem 0 0;">{{ $course->lessons_count }} lessons</p>
                </div>
            </a>
        @empty
            <div class="panel muted" style="padding:1.5rem; border-style:dashed;">
                No published courses yet.
            </div>
        @endforelse
    </div>

    {{ $courses->links() }}
</div>
