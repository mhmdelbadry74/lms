# ERD

## Core Relationships

- A course has many lessons.
- A user has many enrollments.
- An enrollment belongs to one user and one course.
- A user has many lesson progress records.
- A user has at most one course completion per course.
- A user has at most one certificate per course.

## Diagram

```mermaid
erDiagram
    COURSES ||--o{ LESSONS : has
    USERS ||--o{ ENROLLMENTS : has
    COURSES ||--o{ ENROLLMENTS : has
    USERS ||--o{ LESSON_PROGRESS : has
    LESSONS ||--o{ LESSON_PROGRESS : tracks
    USERS ||--o{ COURSE_COMPLETIONS : has
    COURSES ||--o{ COURSE_COMPLETIONS : completes
    USERS ||--o{ CERTIFICATES : receives
    COURSES ||--o{ CERTIFICATES : awards
```
