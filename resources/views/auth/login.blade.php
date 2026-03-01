@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-md rounded-3xl bg-white p-8 shadow-sm">
        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-700">Auth</p>
        <h1 class="mt-2 text-3xl font-bold">Sign in</h1>

        <form method="POST" action="{{ route('login.store') }}" class="mt-6 space-y-4">
            @csrf
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Email</label>
                <input name="email" type="email" value="{{ old('email') }}" required class="w-full rounded-xl border border-slate-300 px-3 py-2">
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Password</label>
                <input name="password" type="password" required class="w-full rounded-xl border border-slate-300 px-3 py-2">
            </div>

            <button type="submit" class="w-full rounded-xl bg-sky-600 px-4 py-3 text-sm font-semibold text-white">
                Sign in
            </button>
        </form>
    </div>
@endsection
