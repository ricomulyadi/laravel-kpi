```blade
@extends('layouts.app')

@section('title', 'Kinerja Individu')

@section('content')
<style>
    .member-dashboard {
        --md-bg: #101411;
        --md-card: #171d18;
        --md-border: #2b362c;
        --md-green: #b6ff65;
        --md-muted: #9ba99a;
        color: #f3f6f1;
        min-height: 100vh;
        padding: 32px;
        background: var(--md-bg);
    }

    .member-dashboard * {
        box-sizing: border-box;
    }

    .md-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .md-topbar, .md-row, .md-section-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .md-brand {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .md-brand-mark {
        display: grid;
        place-items: center;
        width: 44px;
        height: 44px;
        border-radius: 13px;
        background: var(--md-green);
        color: #11170d;
        font-weight: 900;
        font-size: 20px;
    }

    .md-brand strong, .md-brand small {
        display: block;
    }

    .md-brand strong {
        letter-spacing: 1px;
        font-size: 13px;
    }

    .md-brand small {
        color: var(--md-muted);
        margin-top: 4px;
        font-size: 10px;
        letter-spacing: 1.4px;
    }

    .md-status {
        color: var(--md-muted);
        font-size: 12px;
    }

    .md-status span {
        display: inline-block;
        width: 7px;
        height: 7px;
        background: var(--md-green);
        border-radius: 50%;
        margin-right: 7px;
    }

    .md-hero {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        margin: 44px 0 30px;
    }

    .md-eyebrow {
        color: var(--md-green);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 2px;
    }

    .md-hero h1 {
        margin: 12px 0;
        font-size: clamp(28px, 4vw, 42px);
        letter-spacing: -1.5px;
        line-height: 1.15;
    }

    .md-hero h1 span {
        color: var(--md-green);
    }

    .md-hero p {
        color: var(--md-muted);
        line-height: 1.7;
        margin: 0;
    }

    .md-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .md-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        padding: 13px 17px;
        border: 1px solid var(--md-border);
        border-radius: 12px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: transform .2s, background .2s;
    }

    .md-btn:hover {
        transform: translateY(-2px);
    }

    .md-btn-primary {
        color: #11170d;
        background: var(--md-green);
        border-color: var(--md-green);
    }

    .md-btn-secondary {
        color: #f3f6f1;
        background: var(--md-card);
    }

    .md-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 28px;
    }

    .md-card {
        background: var(--md-card);
        border: 1px solid var(--md-border);
        border-radius: 18px;
        padding: 22px;
        min-width: 0;
    }

    .md-stat-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        color: var(--md-muted);
        font-size: 12px;
    }

    .md-stat-icon {
        display: grid;
        place-items: center;
        width: 36px;
        height: 36px;
        border-radius: 11px;
        color: var(--md-green);
        background: #263323;
        font-size: 17px;
    }

    .md-stat-value {
        margin-top: 22px;
        font-size: 32px;
        font-weight: 800;
        letter-spacing: -1px;
    }

    .md-stat-note {
        margin-top: 7px;
        color: var(--md-muted);
        font-size: 11px;
    }

    .md-main-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.7fr) minmax(260px, 1fr);
        gap: 20px;
    }

    .md-section-heading {
        margin-bottom: 20px;
    }

    .md-section-heading h2 {
        font-size: 17px;
        margin: 0 0 6px;
    }

    .md-section-heading p {
        font-size: 12px;
        color: var(--md-muted);
        margin: 0;
    }

    .md-tag {
        display: inline-block;
        color: var(--md-green);
        background: #263323;
        border-radius: 8px;
        padding: 7px 9px;
        font-size: 10px;
        font-weight: 700;
    }

    .md-empty {
        border: 1px dashed #384439;
        border-radius: 13px;
        padding: 32px 16px;
        text-align: center;
    }

    .md-empty-icon {
        font-size: 30px;
        color: var(--md-green);
        margin-bottom: 12px;
    }

    .md-empty h3 {
        font-size: 14px;
        margin: 0 0 8px;
    }

    .md-empty p {
        color: var(--md-muted);
        font-size: 12px;
        line-height: 1.7;
        margin: 0 0 18px;
    }

    .md-task-list {
        display: grid;
        gap: 12px;
    }

    .md-task {
        padding: 15px;
        border: 1px solid var(--md-border);
        border-radius: 12px;
        background: #131814;
    }

    .md-task h3 {
        font-size: 13px;
        margin: 0 0 8px;
        overflow-wrap: anywhere;
    }

    .md-task-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 8px 14px;
        color: var(--md-muted);
        font-size: 11px;
    }

    .md-side-card + .md-side-card {
        margin-top: 16px;
    }

    .md-tip-icon {
        display: grid;
        place-items: center;
        width: 42px;
        height: 42px;
        border-radius: 13px;
        background: #263323;
        color: var(--md-green);
        font-size: 20px;
        margin-bottom: 18px;
    }

    .md-side-card h3 {
        font-size: 15px;
        margin: 0 0 10px;
    }

    .md-side-card p {
        color: var(--md-muted);
        font-size: 12px;
        line-height: 1.8;
        margin: 0;
    }

    .md-logout {
        margin-top: 18px;
        width: 100%;
    }

    .md-footer {
        margin-top: 32px;
        padding-top: 20px;
        border-top: 1px solid var(--md-border);
        color: var(--md-muted);
        font-size: 10px;
        letter-spacing: 1px;
    }

    @media (max-width: 1000px) {
        .md-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .md-main-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {
        .member-dashboard {
            padding: 20px 15px;
        }

        .md-hero {
            align-items: flex-start;
            flex-direction: column;
            margin-top: 32px;
        }

        .md-topbar {
            align-items: flex-start;
        }

        .md-status {
            display: none;
        }

        .md-stats {
            gap: 10px;
        }

        .md-card {
            padding: 15px;
        }

        .md-stat-value {
            font-size: 27px;
        }

        .md-actions, .md-actions .md-btn {
            width: 100%;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .md-btn {
            transition: none;
        }
    }
</style>

<div class="member-dashboard">
    <div class="md-container">

        <header class="md-topbar">
            <div class="md-brand">
                <div class="md-brand-mark">M</div>
                <div>
                    <strong>MIND CORPORA</strong>
                    <small>PRODUCTION SYSTEM</small>
                </div>
            </div>

            <div class="md-status">
                <span></span> Workspace internal
            </div>
        </header>

        <section class="md-hero">
            <div>
                <div class="md-eyebrow">YOUR PRODUCTION WORKSPACE</div>

                <h1>
                    Halo, {{ auth()->user()->name }}.<br>
                    Kelola kinerjamu <span>lebih baik.</span>
                </h1>

                <p>
                    Pantau pekerjaan, catat progres, dan lihat perkembangan
                    kinerja individumu dalam satu tempat.
                </p>
            </div>

            <div class="md-actions">
                <a href="{{ route('tasks.create') }}" class="md-btn md-btn-primary">
                    <span>＋</span> Input Tugas Baru
                </a>
            </div>
        </section>

        <section class="md-stats">
            <article class="md-card">
                <div class="md-stat-top">
                    Total tugas
                    <span class="md-stat-icon">▤</span>
                </div>
                <div class="md-stat-value">{{ $totalTasks ?? '—' }}</div>
                <div class="md-stat-note">Seluruh tugas yang tercatat</div>
            </article>

            <article class="md-card">
                <div class="md-stat-top">
                    Tugas selesai
                    <span class="md-stat-icon">✓</span>
                </div>
                <div class="md-stat-value">{{ $completedTasks ?? '—' }}</div>
                <div class="md-stat-note">Tugas yang sudah diselesaikan</div>
            </article>

            <article class="md-card">
                <div class="md-stat-top">
                    Dalam proses
                    <span class="md-stat-icon">◷</span>
                </div>
                <div class="md-stat-value">{{ $activeTasks ?? '—' }}</div>
                <div class="md-stat-note">Tugas yang masih berjalan</div>
            </article>

            <article class="md-card">
                <div class="md-stat-top">
                    Tepat waktu
                    <span class="md-stat-icon">↗</span>
                </div>
                <div class="md-stat-value">
                    {{ isset($onTimePercentage) ? $onTimePercentage . '%' : '—' }}
                </div>
                <div class="md-stat-note">Persentase tugas selesai tepat waktu</div>
            </article>
        </section>

        <div class="md-main-grid">

            <section class="md-card">
                <div class="md-section-heading">
                    <div>
                        <h2>Daftar Tugas Saya</h2>
                        <p>Pantau pekerjaan dan deadline terbaru.</p>
                    </div>

                    <span class="md-tag">MY TASKS</span>
                </div>

                @if(isset($recentTasks) && $recentTasks->isNotEmpty())
                    <div class="md-task-list">
                        @foreach($recentTasks as $task)
                            <article class="md-task">
                                <div class="md-row">
                                    <h3>{{ $task->task_name }}</h3>
                                    <span class="md-tag">{{ $task->status }}</span>
                                </div>

                                <div class="md-task-meta">
                                    <span>{{ $task->task_code }}</span>

                                    @if($task->project_name)
                                        <span>{{ $task->project_name }}</span>
                                    @endif

                                    <span>
                                        Deadline:
                                        {{ \Illuminate\Support\Carbon::parse($task->deadline)->format('d M Y') }}
                                    </span>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="md-empty">
                        <div class="md-empty-icon">✳</div>
                        <h3>Belum ada tugas yang tercatat</h3>
                        <p>
                            Mulai catat pekerjaan pertamamu agar progres
                            dan kinerja individu dapat dipantau.
                        </p>

                        <a href="{{ route('tasks.create') }}"
                           class="md-btn md-btn-primary">
                            ＋ Input Tugas Pertama
                        </a>
                    </div>
                @endif
            </section>

            <aside>
                <section class="md-card md-side-card">
                    <div class="md-section-heading">
                        <div>
                            <h2>Kinerja Individu</h2>
                            <p>Ringkasan performa personal.</p>
                        </div>
                    </div>

                    <div class="md-tip-icon">↗</div>

                    <h3>Build consistency, deliver quality.</h3>

                    <p>
                        Catat setiap pekerjaan dengan nama tugas, brief,
                        dan deadline yang jelas. Data yang konsisten akan
                        membantu evaluasi KPI menjadi lebih akurat.
                    </p>

                    <a href="{{ route('tasks.create') }}"
                       class="md-btn md-btn-secondary"
                       style="width:100%; margin-top:20px;">
                        Catat pekerjaan
                    </a>
                </section>

                <section class="md-card md-side-card">
                    <div class="md-tip-icon">✳</div>

                    <h3>Small tip, better work.</h3>

                    <p>
                        Tentukan prioritas, pahami brief, dan perhatikan
                        deadline sebelum mulai mengerjakan tugas.
                    </p>
                </section>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="md-btn md-btn-secondary md-logout">
                        ↪ Logout
                    </button>
                </form>
            </aside>

        </div>

        <footer class="md-footer">
            MIND CORPORA INDONESIA · DESIGN · VIDEO · CREATIVE PRODUCTION
        </footer>

    </div>
</div>
@endsection
