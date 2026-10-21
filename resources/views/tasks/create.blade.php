
@extends('layouts.app')

@section('title', 'Catat Tugas Baru')

@section('content')
<main class="task-page">
    <header class="task-topbar">
        <a class="task-brand" href="/">
            <span class="task-brand-mark">M</span>
            <span>
                <strong>MIND CORPORA</strong>
                <small>PRODUCTION SYSTEM</small>
            </span>
        </a>
        <span class="system-status"><i></i> Workspace internal</span>
    </header>

    <section class="task-heading">
        <div>
            <span class="task-eyebrow">TASK MANAGEMENT / NEW ENTRY</span>
            <h1>Catat tugas <span id="typingText">baru.</span><span class="typing-cursor">|</span></h1>
            <p>Mulai dengan brief yang jelas. Progres yang baik dimulai dari pencatatan yang rapi.</p>
        </div>
        <div class="heading-icon" aria-hidden="true">↗</div>
    </section>

    @if(session('success'))
        <div class="task-alert task-success" role="status">
            <span>✓</span> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="task-alert task-error" role="alert">
            <strong>Ada yang perlu diperbaiki</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="task-layout">
        <form id="taskForm" class="task-form-card"
              action="{{ route('tasks.store') }}" method="POST">
            @csrf

            <div class="form-card-heading">
                <div class="section-number">01</div>
                <div>
                    <h2>Informasi tugas</h2>
                    <p>Tentukan kategori dan identitas pekerjaan.</p>
                </div>
            </div>

            <div class="field">
                <label for="source">Sumber pekerjaan <span>*</span></label>
                <div class="choice-grid">
                    <label class="choice-card">
                        <input type="radio" name="source" value="Internal"
                            {{ old('source', 'Internal') === 'Internal' ? 'checked' : '' }} required>
                        <span class="choice-icon">◈</span>
                        <span class="choice-copy">
                            <strong>Internal</strong>
                            <small>Keperluan internal MCA</small>
                        </span>
                        <span class="choice-check">✓</span>
                    </label>

                    <label class="choice-card">
                        <input type="radio" name="source" value="Client"
                            {{ old('source') === 'Client' ? 'checked' : '' }} required>
                        <span class="choice-icon">↗</span>
                        <span class="choice-copy">
                            <strong>Client</strong>
                            <small>Proyek untuk klien</small>
                        </span>
                        <span class="choice-check">✓</span>
                    </label>
                </div>
            </div>

            <div class="field">
                <label for="department">Departemen <span>*</span></label>
                <div class="select-wrap">
                    <select id="department" name="department" required>
                        <option value="Graphic Design"
                            {{ old('department', 'Graphic Design') === 'Graphic Design' ? 'selected' : '' }}>
                            Graphic Design
                        </option>
                        <option value="Visual Production"
                            {{ old('department') === 'Visual Production' ? 'selected' : '' }}>
                            Visual Production
                        </option>
                    </select>
                    <span class="select-arrow">⌄</span>
                </div>
            </div>

            <div class="field">
                <label for="task_type">Jenis tugas <span>*</span></label>
                <div class="select-wrap">
                    <select id="task_type" name="task_type" required>
                        @foreach([
                            'Carousel', 'Static Post', 'Reels', 'Video',
                            'Photography', 'Branding', 'Website', 'Other'
                        ] as $type)
                            <option value="{{ $type }}"
                                {{ old('task_type', 'Carousel') === $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                    <span class="select-arrow">⌄</span>
                </div>
            </div>

            <div class="field">
                <label for="task_name">Nama tugas <span>*</span></label>
                <input id="task_name" name="task_name"
                       value="{{ old('task_name') }}" required maxlength="255"
                       placeholder="Contoh: Carousel edukasi brand">
                <small class="field-hint">Gunakan nama yang singkat dan mudah dikenali.</small>
            </div>

            <div class="field" id="projectField">
                <label for="project_name">Nama proyek / klien <span id="projectRequired">*</span></label>
                <input id="project_name" name="project_name"
                       value="{{ old('project_name') }}" maxlength="255"
                       placeholder="Contoh: Kampanye brand Oktober">
                <small class="field-hint" id="projectHint">
                    Wajib diisi untuk pekerjaan client.
                </small>
            </div>

            <div class="form-divider"></div>

            <div class="form-card-heading">
                <div class="section-number">02</div>
                <div>
                    <h2>Brief & deadline</h2>
                    <p>Berikan konteks agar pekerjaan lebih terarah.</p>
                </div>
            </div>

            <div class="field">
                <label for="deadline">Deadline <span>*</span></label>
                <input id="deadline" type="date" name="deadline"
                       value="{{ old('deadline') }}"
                       min="{{ now()->toDateString() }}" required>
                <small class="field-hint">Pilih tanggal target penyelesaian.</small>
            </div>

            <div class="field">
                <div class="label-row">
                    <label for="brief">Brief tugas</label>
                    <span class="optional-tag">OPSIONAL</span>
                </div>
                <textarea id="brief" name="brief" rows="5" maxlength="5000"
                    placeholder="Tuliskan kebutuhan visual, referensi, ukuran, pesan utama, dan arahan khusus...">{{ old('brief') }}</textarea>
                <div class="textarea-footer">
                    <span>Semakin jelas brief, semakin minim revisi.</span>
                    <span id="briefCount">0 / 5000</span>
                </div>
            </div>

            <div class="form-actions">
                <a href="/" class="btn-secondary">Batal</a>
                <button type="submit" id="submitTask" class="btn-submit">
                    <span>Simpan tugas</span>
                    <span class="submit-arrow">↗</span>
                </button>
            </div>
            <p class="privacy-note">🔒 Data tugas dicatat ke sistem produksi internal.</p>
        </form>

        <aside class="task-side">
            <div class="progress-card">
                <span class="side-eyebrow">FORM PROGRESS</span>
                <div class="progress-number"><span id="progressValue">0</span><small>%</small></div>
                <div class="progress-track"><span id="progressBar"></span></div>
                <p id="progressText">Lengkapi informasi untuk melanjutkan.</p>
                <div class="progress-items">
                    <div><span id="checkName">○</span> Nama tugas</div>
                    <div><span id="checkDepartment">✓</span> Departemen</div>
                    <div><span id="checkDeadline">○</span> Deadline</div>
                    <div><span id="checkBrief">○</span> Brief tugas</div>
                </div>
            </div>

            <div class="tip-card">
                <span class="tip-icon">✳</span>
                <h3>Small tip, better work.</h3>
                <p>Tuliskan tujuan, format output, dan referensi utama pada brief. Tim akan lebih mudah memahami ekspektasi sejak awal.</p>
            </div>

            <div class="task-side-footer">
                MIND CORPORA<br>
                <span>DESIGN · VIDEO · CREATIVE PRODUCTION</span>
            </div>
        </aside>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const typingText = document.getElementById('typingText');

            if (typingText) {
                const words = ['baru.', 'kreatif.', 'terarah.', 'berkualitas.'];
                let wordIndex = 0;
                let charIndex = words[0].length;
                let deleting = true;

                function typeEffect() {
                    const word = words[wordIndex];

                    if (deleting) {
                        charIndex--;
                    } else {
                        charIndex++;
                    }

                    typingText.textContent = word.substring(0, charIndex);

                    let delay = deleting ? 60 : 100;

                    if (deleting && charIndex <= 0) {
                        deleting = false;
                        wordIndex = (wordIndex + 1) % words.length;
                        delay = 250;
                    } else if (!deleting && charIndex >= words[wordIndex].length) {
                        deleting = true;
                        delay = 1200;
                    }

                    setTimeout(typeEffect, delay);
                }

                setTimeout(typeEffect, 1000);
        }
        const form = document.getElementById('taskForm');
        const project = document.getElementById('project_name');
        const projectRequired = document.getElementById('projectRequired');
        const projectHint = document.getElementById('projectHint');
        const brief = document.getElementById('brief');
        const sourceRadios = document.querySelectorAll('input[name="source"]');

        function updateSource() {
            const source = document.querySelector('input[name="source"]:checked')?.value;
            const isClient = source === 'Client';

            project.required = isClient;
            projectRequired.style.display = isClient ? 'inline' : 'none';
            projectHint.textContent = isClient
                ? 'Wajib diisi untuk pekerjaan client.'
                : 'Opsional untuk pekerjaan internal.';

            document.getElementById('projectField').classList.toggle('is-client', isClient);
            updateProgress();
        }

        function updateProgress() {
            const checks = {
                checkName: !!document.getElementById('task_name').value.trim(),
                checkDepartment: !!document.getElementById('department').value,
                checkDeadline: !!document.getElementById('deadline').value,
                checkBrief: !!brief.value.trim()
            };

            const source = document.querySelector('input[name="source"]:checked')?.value;
            const clientOk = source !== 'Client' || !!project.value.trim();
            const sourceOk = !!source;

            const completed = Object.values(checks).filter(Boolean).length;
            const total = 6;
            const score = completed + (clientOk ? 1 : 0) + (sourceOk ? 1 : 0);
            const percent = Math.round(score / 6 * 100);

            document.getElementById('progressValue').textContent = percent;
            document.getElementById('progressBar').style.width = percent + '%';

            Object.entries(checks).forEach(([id, done]) => {
                document.getElementById(id).textContent = done ? '✓' : '○';
                document.getElementById(id).classList.toggle('complete', done);
            });

            document.getElementById('progressText').textContent = percent === 100
                ? 'Semua informasi sudah lengkap.'
                : 'Lengkapi informasi untuk melanjutkan.';
        }

        sourceRadios.forEach(radio => radio.addEventListener('change', updateSource));
        form.querySelectorAll('input, select, textarea').forEach(input => {
            input.addEventListener('input', updateProgress);
            input.addEventListener('change', updateProgress);
        });

        brief.addEventListener('input', function () {
            document.getElementById('briefCount').textContent =
                brief.value.length + ' / 5000';
        });

        form.addEventListener('submit', function () {
            const button = document.getElementById('submitTask');
            if (form.checkValidity()) {
                button.classList.add('is-loading');
                button.querySelector('span:first-child').textContent = 'Menyimpan...';
                button.disabled = true;
            }
        });

        updateSource();
        updateProgress();
        document.getElementById('briefCount').textContent = brief.value.length + ' / 5000';
    });
</script>
@endsection
