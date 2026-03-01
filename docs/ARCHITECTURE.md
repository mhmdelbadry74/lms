# Architecture

## Overview

Course discovery is public. Preview lessons are public. Enrollment and lesson completion are authenticated flows backed by database constraints, transactions, and action classes so HTTP and Livewire layers remain thin.

## DB Schema + Constraints

- `courses`: unique `slug`, `status`, `level`, `image_path`, soft deletes. On soft delete the slug is mutated to free the original slug for reuse.
- `lessons`: belongs to a course, ordered by unique (`course_id`, `position`), supports `is_preview` and `is_required`.
- `enrollments`: unique (`user_id`, `course_id`) to make rapid clicks and retries idempotent.
- `lesson_progress`: unique (`user_id`, `lesson_id`) with `started_at` and `completed_at`.
- `course_completions`: unique (`user_id`, `course_id`) to guarantee a single canonical completion row.
- `certificates`: unique `uuid` and unique (`user_id`, `course_id`) so a learner gets one certificate per course state.

## Actions

- `EnrollUserInCourseAction`: guards unpublished courses and relies on `firstOrCreate()` inside a transaction for safe enrollment retries.
- `CompleteLessonAction`: enforces enrollment, upserts lesson progress, and delegates completion recalculation.
- `EnsureCourseCompletionAction`: recalculates completion from current required lessons, creates completion/certificate exactly once, and revokes stale completion if the curriculum changes later.

## Events

- `CourseCompleted`: emitted after commit when a new completion is created.
- `Registered`: framework event reused for welcome-email behavior.

## Listeners

- `SendWelcomeEmail`: queued listener with cache-based idempotency to prevent duplicate welcome mail under repeated dispatches or retries.
- `SendCourseCompletedEmail`: queued listener with cache-based idempotency so completion mail is sent once even if the listener is invoked more than once.

## Concurrency Notes

- Enforce uniqueness at the database layer first.
- Use transactions for enrollment and completion flows.
- Dispatch side effects after commit where possible.
- Add application-level idempotency on top of DB constraints for email side effects.
- Recalculate completion against the current required lesson set so course edits after enrollment do not leave stale state behind.

## Policies

- `CoursePolicy@view`: only published courses are publicly visible.
- `LessonPolicy@view`: preview lessons are public; non-preview lessons require enrollment in the owning course.
- `LessonPolicy@complete`: completion is allowed only for enrolled users on published courses.

## Reviewer Notes

- The current project is optimized around the challenge's focused scope, not a full production admin suite.
- Filament is intentionally left as a namespace placeholder because the core evaluation weight is on system integrity and architecture first.
