
@extends('layouts.app')

@section('title', 'Dashboard Admin | MIND CORPORA')

@section('content')
<style>
    .admin-dashboard {
        min-height: 100vh;
        padding: 32px;
        background: #090e13;
        color: #eef2f4;
        font-family: Arial, sans-serif;
    }

    .admin-wrap {
        max-width: 1250px;
        margin: auto;
    }

    .admin-topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 38px;
    }

    .admin-brand {
        color: #baff57;
        font-size: 11px;
        letter-spacing: 2px;
        font-weight: bold;
    }

    .admin-heading {
        font-size: 30px;
        margin: 12px 0 8px;
    }

    .admin-muted {
        color: #8e9ba6;
        font-size: 13px;
        line-height: 1.7;
    }

    .admin-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 16px;
        border: 1px solid #35452c;
        border-radius: 9px;
        background: #baff57;
        color: #11180b;
        font-size: 12px;
        font-weight: bold;
        text-decoration: none;
        cursor: pointer;
    }

    .admin-btn-secondary {
        color: #d7e0e7;
        background: #131c24;
        border-color: #2a3742;
    }

    .admin-section-title {
        font-size: 17px;
        margin: 0 0 16px;
    }

    .admin-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 32px;
    }

    .admin-stat {
        padding: 22px;
        background: #10171e;
        border: 1px solid #26313b;
        border-radius: 14px;
    }

    .admin-stat-label {
        color: #9aa8b3;
        font-size: 12px;
    }

    .admin-stat-number {
        display: block;
        font-size: 32px;
        margin-top: 15px;
    }

    .admin-stat-note {
        margin-top: 8px;
        color: #73818c;
        font-size: 11px;
    }

    .admin-menu {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .admin-menu-card {
        display: block;
        padding: 24px;
        background: #10171e;
        border: 1px solid #26313b;
        border-radius: 14px;
        text-decoration: none;
        color: #eef2f4;
        transition: border-color .2s, transform .2s;
    }

    .admin-menu-card:hover {
        border-color: #baff57;
        transform: translateY(-2px);
    }

    .admin-menu-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        margin-bottom: 18px;
        border-radius: 11px;
        background: #1c2b1b;
        color: #baff57;
        font-size: 22px;
    }

    .admin-menu-card h3 {
        margin: 0 0 10px;
        font-size: 16px;
    }

    .admin-menu-card p {
        margin: 0;
        color: #8e9ba6;
        font-size: 12px;
        line-height: 1.7;
    }

    .admin-menu-link {
        display: block;
        margin-top: 20px;
        color: #baff57;
        font-size: 12px;
        font-weight: bold;
    }

    .admin-footer {
        margin-top: 32px;
        padding-top: 20px;
        border-top: 1px solid #26313b;
        color: #73818c;
        font-size: 11px;
    }

    @media (max-width: 650px) {
        .admin-dashboard {
            padding: 22px 14px;
        }

        .admin-heading {
            font-size: 25px;
        }

        .admin-stats {
            grid-template-columns: 1fr;
        }

        .admin-menu {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="admin-dashboard">
    <div class="admin-wrap">

        <header class="admin-topbar">
            <div>
                <div class="admin-brand">MIND CORPORA / PRODUCTION</div>
                <h1 class="admin-heading">Dashboard Admin</h1>
                <p class="admin-muted">
                    Selamat datang, {{ auth()->user()->name }}.
                    Kelola akun dan pantau sistem produksi dari sini.
                </p>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="admin-btn admin-btn-secondary" type="submit">
                    Keluar ↗
                </button>
            </form>
        </header>

        <section>
            <h2 class="admin-section-title">Ringkasan Akun</h2>

            <div class="admin-stats">
                <div class="admin-stat">
                    <span class="admin-stat-label">Total Akun</span>
                    <strong class="admin-stat-number">
                        {{ $totalUsers }}
                    </strong>
                    <div class="admin-stat-note">Seluruh akun terdaftar</div>
                </div>

                <div class="admin-stat">
                    <span class="admin-stat-label">Akun Aktif</span>
                    <strong class="admin-stat-number" style="color:#baff57">
                        {{ $activeUsers }}
                    </strong>
                    <div class="admin-stat-note">Akun yang dapat digunakan</div>
                </div>

                <div class="admin-stat">
                    <span class="admin-stat-label">Akun Nonaktif</span>
                    <strong class="admin-stat-number" style="color:#ff9ca7">
                        {{ $inactiveUsers }}
                    </strong>
                    <div class="admin-stat-note">Akun yang dinonaktifkan</div>
                </div>
            </div>
        </section>

        <section>
            <h2 class="admin-section-title">Menu Administrasi</h2>

            <div class="admin-menu">
                <a href="{{ route('admin.users.index') }}"
                   class="admin-menu-card">
                    <div class="admin-menu-icon">♙</div>
                    <h3>Manajemen Anggota</h3>
                    <p>
                        Tambah akun baru, ubah data pengguna,
                        atur role, dan aktifkan atau nonaktifkan akun.
                    </p>
                    <span class="admin-menu-link">
                        Buka Manajemen Anggota →
                    </span>
                </a>

                <div class="admin-menu-card">
                    <div class="admin-menu-icon">▤</div>
                    <h3>Monitoring KPI Produksi</h3>
                    <p>
                        Area untuk memantau performa produksi,
                        target bulanan, penyelesaian tugas, dan revisi.
                    </p>
                    <span class="admin-menu-link">
                        Modul KPI akan dihubungkan berikutnya
                    </span>
                </div>
            </div>
        </section>

        <footer class="admin-footer">
            MIND CORPORA INDONESIA · Production KPI System
        </footer>

    </div>
</div>
@endsection
