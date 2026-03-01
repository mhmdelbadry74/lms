<div
    x-data="{
        confirmOpen: false,
        progress: {{ $progressPercent }},
        shownProgress: 0,
        player: null,
        init() {
            requestAnimationFrame(() => { this.shownProgress = this.progress; });
            this.player = { destroy() {} };
        }
    }"
    style="display:grid; gap:1.5rem;"
>
    <a href="{{ route('courses.show', $course->slug) }}" style="font-weight:700; color:var(--accent);">Back to course</a>

    <div class="panel" style="padding:1.5rem;">
        <p class="badge badge-brand">Lesson {{ $lesson->position }}</p>
        <h1 style="margin:0.9rem 0 0; font-size:2rem;">{{ $lesson->title }}</h1>
        <p class="muted" style="margin:0.75rem 0 0;">Plyr placeholder is mounted inside Alpine lifecycle hooks. Replace the placeholder block with the real player asset when bundling frontend assets.</p>

        <div id="plyr-player" class="panel" style="margin-top:1rem; padding:1rem; background:var(--panel-muted);">
            <div style="aspect-ratio:16/9; border-radius:1rem; display:grid; place-items:center; background:linear-gradient(135deg, rgba(14,165,233,0.14), rgba(20,184,166,0.14));">
                <strong>Video Player Placeholder</strong>
            </div>
        </div>
    </div>

    <div class="panel" style="padding:1.5rem;">
        <div style="display:flex; align-items:center; justify-content:space-between; gap:1rem;">
            <div>
                <h2 style="margin:0; font-size:1.15rem;">Course Progress</h2>
                <p class="muted" style="margin:0.4rem 0 0;">Based on completed required lessons only.</p>
            </div>
            <strong x-text="`${shownProgress}%`"></strong>
        </div>

        <div style="margin-top:1rem; height:0.8rem; border-radius:999px; background:var(--panel-muted); overflow:hidden;">
            <div style="height:100%; background:linear-gradient(90deg, var(--brand), var(--accent)); transition:width 500ms ease;" x-bind:style="`width:${shownProgress}%`"></div>
        </div>
    </div>

    @auth
        <div class="panel" style="padding:1.5rem;">
            <button type="button" class="btn btn-primary" x-on:click="confirmOpen = true">Mark Lesson Complete</button>

            <div x-show="confirmOpen" style="position:fixed; inset:0; background:rgba(15,23,42,0.55); display:grid; place-items:center; padding:1rem;">
                <div class="panel" style="max-width:28rem; width:100%; padding:1.5rem;">
                    <h3 style="margin:0; font-size:1.1rem;">Confirm completion</h3>
                    <p class="muted" style="margin:0.75rem 0 1rem;">This action is idempotent, but it should only be used when the lesson is actually finished.</p>
                    <div style="display:flex; gap:0.75rem; justify-content:flex-end; flex-wrap:wrap;">
                        <button type="button" class="btn" x-on:click="confirmOpen = false">Cancel</button>
                        <form method="POST" action="{{ route('lessons.complete', ['slug' => $course->slug, 'lesson' => $lesson->id]) }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endauth
</div>
