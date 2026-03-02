@extends('layouts.app')

@section('content')
    <div style="display:grid; gap:1.5rem; grid-template-columns:repeat(auto-fit, minmax(18rem, 1fr)); align-items:start;">
        <section class="panel" style="padding:1.75rem;">
            <p class="eyebrow">Sign In</p>
            <h1 style="margin:0.7rem 0 0; font-size:2.4rem; line-height:1.02;">Welcome Back</h1>
            <p class="muted" style="margin:0.85rem 0 0;">Use one of the seeded demo accounts or sign in with your own account to test enrollment, completion, and certificate flows.</p>

            <div class="grid-auto" style="margin-top:1.4rem;">
                <div class="metric">
                    <strong>demo</strong>
                    <span class="muted">Has completed courses and certificates</span>
                </div>
                <div class="metric">
                    <strong>partial</strong>
                    <span class="muted">Has in-progress enrollment</span>
                </div>
            </div>

            <div class="panel" style="margin-top:1.4rem; padding:1rem; background:var(--panel-muted);">
                <p class="eyebrow">Demo Credentials</p>
                <div style="display:grid; gap:0.85rem; margin-top:0.9rem;">
                    <div>
                        <strong style="display:block;">demo@example.com</strong>
                        <span class="muted">password</span>
                    </div>
                    <div>
                        <strong style="display:block;">partial@example.com</strong>
                        <span class="muted">password</span>
                    </div>
                    <div>
                        <strong style="display:block;">completed@example.com</strong>
                        <span class="muted">password</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="panel" style="padding:1.75rem;">
            <p class="eyebrow">Auth</p>
            <h2 style="margin:0.7rem 0 0; font-size:1.8rem;">Sign in to continue</h2>

            <form method="POST" action="{{ route('login.store') }}" style="margin-top:1.4rem; display:grid; gap:1rem;">
            @csrf
            <div>
                <label style="display:block; margin-bottom:0.45rem; font-size:0.9rem; font-weight:700;">Email</label>
                <input name="email" type="email" value="{{ old('email') }}" required>
            </div>

            <div>
                <label style="display:block; margin-bottom:0.45rem; font-size:0.9rem; font-weight:700;">Password</label>
                <input name="password" type="password" required>
            </div>

                <button type="submit" class="btn btn-primary" style="width:100%; padding-block:0.9rem;">
                    Sign in
                </button>
            </form>

            <p class="muted" style="margin:1rem 0 0;">
                Need a fresh account?
                <a href="{{ route('register') }}" style="color:var(--accent); font-weight:700;">Create one here</a>
            </p>
        </section>
    </div>
@endsection
