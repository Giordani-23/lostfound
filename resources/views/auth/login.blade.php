@extends('layouts.app')

@section('title', 'Login Admin')

@section('content')

<div style="min-height:80vh;display:flex;align-items:center;justify-content:center;padding:2rem">
    <div style="width:100%;max-width:440px">

        <div class="text-center mb-4">
            <div style="width:72px;height:72px;background:var(--primary-subtle);color:var(--primary);border-radius:24px;display:flex;align-items:center;justify-content:center;font-size:2.5rem;margin:0 auto 1.25rem">
                👋
            </div>
            <h1 style="font-size:1.8rem;font-weight:900;color:var(--accent);letter-spacing:-0.02em">Halo, Admin!</h1>
            <p style="color:var(--text-muted);font-size:1rem;font-weight:500">Silakan login untuk kelola data.</p>
        </div>

        <div class="card" style="border:none;box-shadow:var(--shadow-lg);border-radius:24px">
            <div class="card-body" style="padding:2.5rem">

                @if($errors->any())
                    <div class="alert alert-error" style="border-radius:var(--radius-sm)">❌ {{ $errors->first() }}</div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success" style="border-radius:var(--radius-sm)">✨ {{ session('success') }}</div>
                @endif

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" style="font-size:0.95rem">Email</label>
                        <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                               placeholder="admin@smkn1sby.sch.id"
                               value="{{ old('email') }}" autofocus
                               style="padding:1rem 1.25rem;border-radius:12px;font-weight:500;background:var(--bg)">
                    </div>
                    <div class="form-group">
                        <label class="form-label" style="font-size:0.95rem">Password</label>
                        <input type="password" name="password" class="form-control"
                               placeholder="••••••••"
                               style="padding:1rem 1.25rem;border-radius:12px;font-weight:500;background:var(--bg)">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-lg" style="margin-top:2rem;padding:1.15rem;font-size:1.1rem;border-radius:16px">
                        Masuk Dashboard 🚀
                    </button>
                </form>

            </div>
        </div>

        <p class="text-center mt-4" style="font-size:0.95rem;font-weight:600">
            <a href="{{ route('home') }}" style="color:var(--text-muted)">← Kembali ke Beranda</a>
        </p>

        <div style="background:#fff;border-radius:16px;padding:1rem 1.5rem;margin-top:2rem;border:2px dashed var(--border-dark);text-align:center">
            <p style="font-size:0.85rem;color:var(--text-muted);font-weight:600;margin-bottom:0.25rem">🔑 Akun Demo (untuk testing):</p>
            <p style="font-size:0.9rem;color:var(--accent);font-weight:800">admin@smkn1sby.sch.id <span style="color:var(--text-muted);font-weight:500">/</span> Buyunitacantik123</p>
        </div>
    </div>
</div>

@endsection
