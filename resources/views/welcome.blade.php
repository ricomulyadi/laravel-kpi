@extends('layouts.app')
@section('title', 'Login')
@section('content')
<main class="login-page">
    <section class="login-visual">
        <div class="brand"><div class="brand-mark">M</div><div><strong>MIND CORPORA</strong><span>PRODUCTION SYSTEM</span></div></div>
        <div class="visual-copy">
            <span class="eyebrow"><span class="live-dot"></span> WORKSPACE INTERNAL</span>
            <h1>Good work.<br><em>Measured well.</em></h1>
            <p>Satu ruang untuk memantau produktivitas, kualitas, dan performa tim produksi visual.</p>
            <div class="visual-stats">
                <div><strong>01</strong><span>Track progress</span></div>
                <div><strong>02</strong><span>Measure impact</span></div>
                <div><strong>03</strong><span>Grow together</span></div>
            </div>
        </div>
        <div class="visual-footer"><span>DESIGN · VIDEO · CREATIVE PRODUCTION</span><span>© 2026 MIND CORPORA</span></div>
        <div class="orb orb-one"></div><div class="orb orb-two"></div>
    </section>
    <section class="login-panel">
        <div class="mobile-brand"><div class="brand-mark">M</div><strong>MIND CORPORA</strong></div>
        <div class="login-card">
            <div class="welcome-tag">WELCOME BACK</div>
            <h2>Masuk ke workspace</h2>
            <p class="muted">Gunakan akun internal untuk melanjutkan.</p>
            @if ($errors->any())
                <div class="alert-error">{{ $errors->first() }}</div>
            @endif
            <form method="POST" action="{{ route('login.submit') }}" class="login-form">
                @csrf
                <label for="username">Username</label>
<div class="input-wrap">
    <span class="input-icon">♙</span>
    <input
        id="username"
        type="text"
        name="username"
        placeholder="Masukkan username"
        value="{{ old('username') }}"
        required
        autocomplete="username"
    >
</div>
<label for="password">Password</label>
<div class="input-wrap">
    <span class="input-icon">🔒</span>
    <input
        id="password"
        type="password"
        name="password"
        placeholder="Masukkan password"
        required
        autocomplete="current-password"
    >
    <button
        type="button"
        class="show-password"
        onclick="const p = document.getElementById('password'); p.type = p.type === 'password' ? 'text' : 'password';"
    >Lihat</button>
</div>
<button class="btn-primary" type="submit">
    Masuk ke dashboard
    <span>↗</span>
</button>
            </form>
            <div class="demo-note"><strong>Prototype login</strong><br>Email: <code>admin@mindcorpora.id</code><br>Password: <code>KPI2026!</code></div>
            <p class="security-note"><span>◈</span> Akses terbatas untuk tim internal Mind Corpora.</p>
        </div>
        <div class="panel-footer">Butuh bantuan akses? Hubungi administrator sistem.</div>
    </section>
</main>
@endsection