@extends('layouts.app')

@section('content')
    <div style="display:grid; gap:1.5rem; grid-template-columns:repeat(auto-fit, minmax(18rem, 1fr)); align-items:start;">
        <section class="panel" style="padding:1.75rem;">
            <p class="eyebrow">Register</p>
            <h1 style="margin:0.7rem 0 0; font-size:2.4rem; line-height:1.02;">Create A Learner Account</h1>
            <p class="muted" style="margin:0.85rem 0 0;">Registration immediately unlocks the authenticated flows: enrollment, lesson completion, and certificate generation when required lessons are done.</p>

            <div class="grid-auto" style="margin-top:1.4rem;">
                <div class="metric">
                    <strong>1x</strong>
                    <span class="muted">Welcome email flow</span>
                </div>
                <div class="metric">
                    <strong>Queued</strong>
                    <span class="muted">Listener-based side effects</span>
                </div>
            </div>
        </section>

        <section class="panel" style="padding:1.75rem;">
            <p class="eyebrow">Auth</p>
            <h2 style="margin:0.7rem 0 0; font-size:1.8rem;">Open a new account</h2>

            <form method="POST" action="{{ route('register.store') }}" style="margin-top:1.4rem; display:grid; gap:1rem;">
            @csrf
            <div>
                <label style="display:block; margin-bottom:0.45rem; font-size:0.9rem; font-weight:700;">Name</label>
                <input name="name" type="text" value="{{ old('name') }}" required>
            </div>

            <div>
                <label style="display:block; margin-bottom:0.45rem; font-size:0.9rem; font-weight:700;">Email</label>
                <input name="email" type="email" value="{{ old('email') }}" required>
            </div>

            <div>
                <label style="display:block; margin-bottom:0.45rem; font-size:0.9rem; font-weight:700;">Password</label>
                <input name="password" type="password" required>
            </div>

            <div>
                <label style="display:block; margin-bottom:0.45rem; font-size:0.9rem; font-weight:700;">Confirm password</label>
                <input name="password_confirmation" type="password" required>
            </div>

                <button type="submit" class="btn btn-primary" style="width:100%; padding-block:0.9rem;">
                    Register
                </button>
            </form>

            <p class="muted" style="margin:1rem 0 0;">
                Already registered?
                <a href="{{ route('login') }}" style="color:var(--accent); font-weight:700;">Sign in instead</a>
            </p>
        </section>
    </div>
@endsection
