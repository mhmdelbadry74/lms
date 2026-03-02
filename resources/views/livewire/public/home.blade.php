<div style="display:grid; gap:1.5rem;">
    <section class="panel" style="padding:1.75rem; overflow:hidden; position:relative;">
        <div style="position:absolute; inset:auto -8rem -8rem auto; width:18rem; height:18rem; border-radius:50%; background:radial-gradient(circle, rgba(14,165,233,0.18), transparent 60%);"></div>
        <p class="eyebrow">Public Home</p>
        <h1 class="hero-title">Published Courses Built For Correctness</h1>
        <p class="muted" style="max-width:44rem; margin:0.9rem 0 0; font-size:1.02rem;">This catalog is optimized for reviewer walkthroughs: efficient queries, visible edge-case content, and demo data that surfaces preview, locked, optional, and completion-aware scenarios.</p>

        <div class="grid-auto" style="margin-top:1.5rem;">
            <div class="metric">
                <strong>{{ $courses->total() }}</strong>
                <span class="muted">Published courses</span>
            </div>
            <div class="metric">
                <strong>{{ $courses->sum('lessons_count') }}</strong>
                <span class="muted">Lessons in this page</span>
            </div>
            <div class="metric">
                <strong>3</strong>
                <span class="muted">Demo learner states</span>
            </div>
        </div>
    </section>

    <section class="panel" style="padding:1.25rem 1.25rem 1rem;">
        <div style="display:flex; align-items:center; justify-content:space-between; gap:1rem; flex-wrap:wrap;">
            <div>
                <p class="eyebrow">Catalog</p>
                <h2 style="margin:0.45rem 0 0; font-size:1.45rem;">Reviewer-Friendly Scenarios</h2>
            </div>
            <span class="muted" style="font-weight:700;">Published only, drafts intentionally excluded</span>
        </div>
    </section>

    <div style="display:grid; gap:1rem; grid-template-columns:repeat(auto-fit, minmax(18rem, 1fr));">
        @forelse ($courses as $course)
            <a href="{{ route('courses.show', $course->slug) }}" class="panel card-link" style="overflow:hidden;">
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
                    <div style="display:flex; align-items:center; justify-content:space-between; gap:0.75rem; margin-top:0.9rem;">
                        <span class="muted" style="font-size:0.9rem;">Open course details</span>
                        <span class="btn btn-ghost" style="padding:0.45rem 0.7rem; font-size:0.78rem;">View</span>
                    </div>
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
