@extends('layouts.app')

@section('title', 'Login Admin')

@section('content')

<div style="min-height:80vh;display:flex;align-items:center;justify-content:center;padding:2rem">
    <div style="width:100%;max-width:420px">

        <div class="text-center mb-3">
            <div style="width:64px;height:64px;background:var(--primary);border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:2rem;margin:0 auto 1rem">🔍</div>
            <h1 style="font-size:1.5rem;font-weight:800">Login Admin</h1>
            <p style="color:var(--text-muted);font-size:0.9rem">Lost & Found SMKN 1 Surabaya</p>
        </div>

        <div class="card">
            <div class="card-body">

                @if($errors->any())
                    <div class="alert alert-error">❌ {{ $errors->first() }}</div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success">✅ {{ session('success') }}</div>
                @endif

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                               placeholder="admin@smkn1sby.sch.id"
                               value="{{ old('email') }}" autofocus>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control"
                               placeholder="••••••••">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-lg mt-1">
                        🔐 Login
                    </button>
                </form>

            </div>
        </div>

        <p class="text-center mt-2" style="font-size:0.85rem;color:var(--text-muted)">
            <a href="{{ route('home') }}" style="color:var(--primary)">← Kembali ke halaman publik</a>
        </p>

        <div style="background:#fff;border-radius:var(--radius-sm);padding:0.75rem 1rem;margin-top:1rem;border:1px solid var(--border);font-size:0.8rem;color:var(--text-muted)">
            🔑 Demo: <strong>admin@smkn1sby.sch.id</strong> / <strong>Buyunitacantik123</strong>
        </div>
    </div>
</div>

@endsection
