@extends('layouts.app')

@section('title', 'Login Admin')

@section('content')

<div style="min-height:80vh;display:flex;align-items:center;justify-content:center;padding:2rem">
    <div style="width:100%;max-width:440px">

        <div class="text-center mb-4">  
            <h1 style="font-size:1.8rem;font-weight:900;color:var(--accent);letter-spacing:-0.02em">Halo, Admin!</h1>
            <p style="color:var(--text-muted);font-size:1rem;font-weight:500">Silakan login untuk kelola data.</p>
        </div>

        <div class="card" style="border:none;box-shadow:var(--shadow-lg);border-radius:24px">
            <div class="card-body" style="padding:2.5rem">

                @if($errors->any())
                    <div class="alert alert-error" style="border-radius:var(--radius-sm)"><i class="fi fi-sr-cross-circle" style="margin-right:6px"></i> {{ $errors->first() }}</div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success" style="border-radius:var(--radius-sm)"><i class="fi fi-sr-check-circle" style="margin-right:6px"></i> {{ session('success') }}</div>
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
                        Masuk Dashboard <i class="fi fi-rr-arrow-right" style="margin-left:6px"></i>
                    </button>
                </form>

            </div>
        </div>

        <p class="text-center mt-4" style="font-size:0.95rem;font-weight:600">
            <a href="{{ route('home') }}" style="color:var(--text-muted)">← Kembali ke Beranda</a>
        </p>
    </div>
</div>

@endsection
