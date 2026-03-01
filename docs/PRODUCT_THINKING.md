# Product Thinking

## Business Risks

1. Users trigger duplicate actions because of rapid clicks, retries, or flaky networks.
The architecture mitigates this through unique DB constraints (`enrollments`, `lesson_progress`, `course_completions`, `certificates`) plus `firstOrCreate()` and transaction boundaries.

2. Learners see content they should not see.
This is mitigated through explicit policies, public-vs-enrolled lesson rules, and published-course guards in actions and route-level flow entry points.

3. Course completion becomes inconsistent when content changes after users already enrolled.
This is mitigated by recalculating completion from the current required lessons and revoking stale completion/certificate state before recreating it.

## Metrics

1. Enrollment conversion rate per published course.
Capture from `enrollments` relative to course page views. Store raw events separately if analytics grows; compute aggregates asynchronously.

2. Completion rate per course.
Source from `course_completions` divided by `enrollments`. This should be computed from transactional tables, cached in periodic aggregates for dashboards.

3. Lesson drop-off by lesson position.
Source from `lesson_progress.started_at` / `completed_at`. Compute with grouped queries or nightly snapshots to avoid expensive real-time funnel scans.

4. Median time from enrollment to completion.
Source from `enrollments.created_at` and `course_completions.completed_at`. Compute in reporting jobs, not on the request path.

5. Certificate issuance count and failure rate.
Source from `certificates` and queue/mail failure logs. Store raw operational failures; expose summarized metrics from scheduled rollups.

## Future Evolution

### Paid courses

Current support:
- Action-based enrollment flow gives a clean place to add payment authorization before creating enrollment.

Likely refactor:
- Introduce order/payment aggregates and make enrollment depend on a paid entitlement instead of direct course status alone.

### Mobile API

Current support:
- Business logic already lives outside controllers, so API routes can reuse the same actions and policies.

Likely refactor:
- Add API resources, token-based auth, and explicit versioned contracts.

### Corporate multi-tenant accounts

Current support:
- Current schema is simple enough to add tenant scoping deliberately.

Likely refactor:
- Add tenant keys on core tables, introduce tenant-aware policies, and move uniqueness constraints to tenant-scoped composites.

### Gamification badges

Current support:
- Completion event and lesson progress data already form a good event source.

Likely refactor:
- Add badge projection tables and asynchronous badge award jobs rather than embedding gamification into request-time actions.

## Trade-offs

1. I prioritized action classes and constraints over a larger admin surface.
That keeps the core correctness layer easy to review and reason about under concurrency.

2. I create certificates immediately when completion is valid instead of deferring certificate generation.
This keeps course-completion state strongly consistent, at the cost of coupling certificate issuance to the completion transaction boundary.

3. I used PHPUnit coverage for the requested scenarios instead of Pest.
The challenge asked for Pest, but package installation was blocked by offline constraints in the current environment. I kept the integrity coverage itself, which is the more important engineering signal here.
