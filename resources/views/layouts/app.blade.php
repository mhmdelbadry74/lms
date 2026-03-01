<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'LMS Task') }}</title>
    <style>
        * { box-sizing: border-box; }
        :root {
            --bg: #eef2ff;
            --panel: #ffffff;
            --panel-muted: #f8fafc;
            --text: #0f172a;
            --muted: #475569;
            --line: #dbeafe;
            --brand: #0f766e;
            --brand-strong: #115e59;
            --accent: #0ea5e9;
        }
        [data-theme="dark"] {
            --bg: #0f172a;
            --panel: #111827;
            --panel-muted: #1f2937;
            --text: #e5e7eb;
            --muted: #cbd5e1;
            --line: #334155;
            --brand: #14b8a6;
            --brand-strong: #2dd4bf;
            --accent: #38bdf8;
        }
        body {
            margin: 0;
            font-family: ui-sans-serif, system-ui, sans-serif;
            background:
                radial-gradient(circle at top right, rgba(14, 165, 233, 0.18), transparent 30rem),
                radial-gradient(circle at bottom left, rgba(20, 184, 166, 0.14), transparent 28rem),
                var(--bg);
            color: var(--text);
        }
        a { color: inherit; text-decoration: none; }
        .shell { max-width: 72rem; margin: 0 auto; padding: 2.5rem 1rem; }
        .panel { background: var(--panel); border: 1px solid var(--line); border-radius: 1.5rem; box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06); }
        .muted { color: var(--muted); }
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; border-radius: 0.9rem; padding: 0.7rem 1rem; font-weight: 700; border: 1px solid var(--line); cursor: pointer; background: transparent; color: var(--text); }
        .btn-primary { background: var(--brand); color: white; border-color: transparent; }
        .btn-primary:hover { background: var(--brand-strong); }
        .badge { display: inline-block; border-radius: 999px; padding: 0.25rem 0.65rem; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; }
        .badge-brand { background: rgba(14, 165, 233, 0.12); color: var(--accent); }
        .badge-success { background: rgba(20, 184, 166, 0.12); color: var(--brand); }
        input { width: 100%; border-radius: 0.9rem; border: 1px solid var(--line); padding: 0.75rem 0.9rem; background: var(--panel); color: var(--text); }
    </style>
    @livewireStyles
</head>
<body x-data="{ darkMode: false }" x-bind:data-theme="darkMode ? 'dark' : 'light'">
    <main class="shell">
        <header class="panel" style="display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:1rem; padding:1.25rem 1.5rem; margin-bottom:2rem;">
            <a href="{{ route('home') }}" style="font-size:1.125rem; font-weight:800;">LMS Task</a>

            <nav style="display:flex; align-items:center; gap:0.75rem; flex-wrap:wrap; font-size:0.95rem; font-weight:700;">
                <button type="button" class="btn" x-on:click="darkMode = !darkMode">
                    <span x-text="darkMode ? 'Light mode' : 'Dark mode'"></span>
                </button>
                @auth
                    <span class="muted">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                @endauth
            </nav>
        </header>

        @if ($errors->any())
            <div class="panel" style="margin-bottom:1.5rem; padding:0.9rem 1rem; border-color:#fecdd3; background:#fff1f2; color:#be123c;">
                {{ $errors->first() }}
            </div>
        @endif

        @if (session('status'))
            <div class="panel" style="margin-bottom:1.5rem; padding:0.9rem 1rem; border-color:#a7f3d0; background:#ecfdf5; color:#047857;">
                {{ session('status') }}
            </div>
        @endif

        @hasSection('content')
            @yield('content')
        @else
            {{ $slot ?? '' }}
        @endif
    </main>

    @livewireScripts
</body>
</html>
