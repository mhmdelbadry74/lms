<?php

use App\Actions\Enrollment\EnrollUserInCourseAction;
use App\Actions\Progress\CompleteLessonAction;
use App\Livewire\Courses\ShowCourse;
use App\Livewire\Lessons\ShowLesson;
use App\Livewire\Public\Home;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\Password;

Route::get('/', Home::class)->name('home');
Route::get('/courses/{slug}', ShowCourse::class)->name('courses.show');
Route::get('/courses/{slug}/lessons/{lesson}', ShowLesson::class)->name('lessons.show');

Route::middleware('guest')->group(function (): void {
    Route::view('/login', 'auth.login')->name('login');
    Route::view('/register', 'auth.register')->name('register');

    Route::post('/login', function (Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, remember: true)) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('home'))->with('status', 'Welcome back.');
    })->name('login.store');

    Route::post('/register', function (Request $request) {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::query()->create($validated);

        event(new Registered($user));
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')->with('status', 'Account created successfully.');
    })->name('register.store');
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', function (Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('status', 'Signed out successfully.');
    })->name('logout');

    Route::post('/courses/{slug}/enroll', function (string $slug, EnrollUserInCourseAction $action) {
        $course = Course::query()->where('slug', $slug)->firstOrFail();
        $action->execute(request()->user(), $course);

        return redirect()->route('courses.show', $course->slug)->with('status', 'Enrollment confirmed.');
    })->name('courses.enroll');

    Route::post('/courses/{slug}/lessons/{lesson}/complete', function (string $slug, Lesson $lesson, CompleteLessonAction $action) {
        abort_unless($lesson->course->slug === $slug, 404);
        Gate::authorize('complete', $lesson);

        $action->execute(request()->user(), $lesson);

        return redirect()->route('lessons.show', ['slug' => $slug, 'lesson' => $lesson->id])->with('status', 'Lesson marked as completed.');
    })->name('lessons.complete');
});
