@extends('layouts.app')

@section('title', 'Manajemen Anggota')

@section('content')
<style>
    .users-page {
        min-height: 100vh;
        background: #090e13;
        color: #eef2f4;
        padding: 30px;
        font-family: Arial, sans-serif;
    }

    .users-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 28px;
    }

    .users-eyebrow {
        color: #baff57;
        font-size: 10px;
        letter-spacing: 2px;
        font-weight: bold;
    }

    .users-header h1 {
        font-size: 30px;
        margin: 10px 0;
    }

    .users-muted {
        color: #8e9ba6;
        font-size: 12px;
        line-height: 1.6;
    }

    .users-btn {
        border: 1px solid #35452c;
        background: #baff57;
        color: #11180b;
        padding: 12px 16px;
        border-radius: 10px;
        font-weight: bold;
        cursor: pointer;
        font-size: 12px;
        text-decoration: none;
    }

    .users-btn-secondary {
        background: #131c24;
        color: #d7e0e7;
        border-color: #2a3742;
    }

    .users-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 20px;
    }

    .users-card,
    .users-panel {
        background: #10171e;
        border: 1px solid #26313b;
        border-radius: 15px;
    }

    .users-card {
        padding: 20px;
    }

    .users-card span {
        color: #9aa8b3;
        font-size: 12px;
    }

    .users-card strong {
        display: block;
        font-size: 29px;
        margin-top: 12px;
    }

    .users-panel {
        padding: 20px;
    }

    .users-alert {
        padding: 12px 15px;
        margin-bottom: 15px;
        border-radius: 9px;
        background: #1c2b1b;
        border: 1px solid #3b552f;
        color: #caff8d;
        font-size: 13px;
    }

    .users-alert-error {
        background: #321d21;
        border-color: #6c343c;
        color: #ffb5be;
    }

    .users-filters {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 18px;
    }

    .users-input,
    .users-select {
        background: #0b1218;
        border: 1px solid #2a3742;
        color: #eef2f4;
        border-radius: 9px;
        padding: 12px;
        min-width: 0;
        font-size: 12px;
    }

    .users-search {
        flex: 1;
        min-width: 180px;
    }

    .users-table-wrap {
        overflow-x: auto;
    }

    .users-table {
        width: 100%;
        border-collapse: collapse;
        white-space: nowrap;
        font-size: 12px;
    }

    .users-table th {
        text-align: left;
        padding: 14px 12px;
        color: #8e9ba6;
        border-bottom: 1px solid #2a3742;
        font-size: 10px;
        letter-spacing: 1px;
    }

    .users-table td {
        padding: 15px 12px;
        border-bottom: 1px solid #202a32;
    }

    .users-role,
    .users-status {
        display: inline-block;
        padding: 6px 9px;
        border-radius: 7px;
        font-size: 10px;
    }
    .users-modal {
        display: none;
    }

    .users-modal.open {
        display: flex;
    }

    .role-admin {
        color: #d9c2ff;
        background: #2a2140;
    }

    .role-lead {
        color: #a9d8ff;
        background: #1c2e40;
    }

    .role-anggota {
        color: #caff8d;
        background: #1c2b1b;
    }

    .status-active {
        color: #caff8d;
        background: #1c2b1b;
    }

    .status-inactive {
        color: #ffb5be;
        background: #321d21;
    }

    .users-row-actions {
        display: flex;
        gap: 7px;
        align-items: center;
    }

    .users-mini-btn {
        background: #131c24;
        color: #d7e0e7;
        border: 1px solid #2a3742;
        padding: 7px 9px;
        border-radius: 7px;
        cursor: pointer;
        font-size: 11px;
    }

    .users-empty {
        padding: 35px !important;
        text-align: center;
        color: #8e9ba6;
        white-space: normal;
    }

    .users-pagination {
        padding-top: 18px;
        color: #9aa8b3;
        font-size: 12px;
    }

    .users-pagination nav p {
        margin-bottom: 10px;
    }

    .users-pagination a,
    .users-pagination span {
        color: #caff8d;
        margin-right: 8px;
    }

    .users-modal {
        position: fixed;
        inset: 0;
        z-index: 1000;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(0, 0, 0, .75);
    }

    .users-modal.open {
        display: flex;
    }

    .users-modal-box {
        width: 100%;
        max-width: 540px;
        max-height: 90vh;
        overflow-y: auto;
        padding: 24px;
        background: #10171e;
        border: 1px solid #303c47;
        border-radius: 16px;
    }

    .users-modal-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .users-modal-head h2 {
        font-size: 19px;
        margin: 0;
    }

    .users-close {
        background: transparent;
        color: #fff;
        border: 0;
        font-size: 25px;
        cursor: pointer;
    }

    .users-form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    .users-field {
        display: flex;
        flex-direction: column;
        gap: 7px;
        margin-bottom: 14px;
    }

    .users-field label {
        color: #aab6bf;
        font-size: 12px;
    }

    .users-field input,
    .users-field select {
        width: 100%;
        box-sizing: border-box;
    }

    .users-modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 12px;
    }

    @media (max-width: 650px) {
        .users-page {
            padding: 20px 13px;
        }

        .users-stats {
            gap: 8px;
        }

        .users-card {
            padding: 13px;
        }

        .users-card strong {
            font-size: 23px;
        }

        .users-card span {
            font-size: 10px;
        }

        .users-form-grid {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .users-header h1 {
            font-size: 25px;
        }
    }
</style>

<div class="users-page">
    <header class="users-header">
        <div>
            <div class="users-eyebrow">ADMINISTRATION / TEAM</div>
            <h1>Manajemen Anggota</h1>
            <div class="users-muted">
                Kelola akun dan hak akses tim Production.
            </div>
        </div>

        
<div style="display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
    <a
        href="{{ route('admin.dashboard') }}"
        class="users-btn users-btn-secondary"
    >
        ← Dashboard
    </a>

    <button
        class="users-btn"
        type="button"
        onclick="openUserModal()"
    >
        + Tambah Anggota
    </button>
</div>

    </header>

    @if (session('success'))
        <div class="users-alert">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="users-alert users-alert-error">
            <ul style="margin:0;padding-left:18px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="users-stats">
        <div class="users-card">
            <span>Total akun</span>
            <strong>{{ $totalUsers }}</strong>
        </div>
        <div class="users-card">
            <span>Akun aktif</span>
            <strong style="color:#baff57;">{{ $activeUsers }}</strong>
        </div>
        <div class="users-card">
            <span>Akun nonaktif</span>
            <strong style="color:#ff9ca7;">{{ $inactiveUsers }}</strong>
        </div>
    </section>

    <section class="users-panel">
        <form method="GET" action="{{ route('admin.users.index') }}" class="users-filters">
            <input
                class="users-input users-search"
                type="search"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama atau username..."
            >

            <select class="users-select" name="role">
                <option value="">Semua role</option>
                <option value="admin" @selected(request('role') === 'admin')>Admin</option>
                <option value="lead" @selected(request('role') === 'lead')>Lead</option>
                <option value="anggota" @selected(request('role') === 'anggota')>Anggota</option>
            </select>

            <button class="users-btn" type="submit">Cari / Filter</button>
            <a class="users-btn users-btn-secondary" href="{{ route('admin.users.index') }}">Reset</a>
        </form>

        <div class="users-table-wrap">
            <table class="users-table">
                <thead>
                    <tr>
                        <th>AKUN</th>
                        <th>USERNAME</th>
                        <th>ROLE</th>
                        <th>STATUS</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>
                                <strong>{{ $user->name }}</strong>
                                <div class="users-muted">{{ $user->email }}</div>
                            </td>
                            <td>{{ $user->username }}</td>
                            <td>
                                <span class="users-role role-{{ $user->role }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                <span class="users-status {{ $user->is_active ? 'status-active' : 'status-inactive' }}">
                                    {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td>
                                <div class="users-row-actions">
                                    <button
                                        type="button"
                                        class="users-mini-btn"
                                        onclick="openEditModal(this)"
                                        data-id="{{ $user->id }}"
                                        data-name="{{ $user->name }}"
                                        data-username="{{ $user->username }}"
                                        data-email="{{ $user->email }}"
                                        data-role="{{ $user->role }}"
                                    >Edit</button>

                                    <form
                                        method="POST"
                                        action="{{ route('admin.users.toggle-active', $user) }}"
                                        onsubmit="return confirm('Yakin ingin mengubah status akun ini?')"
                                    >
                                        @csrf
                                        @method('PATCH')
                                        <button class="users-mini-btn" type="submit">
                                            {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="users-empty">
                                Tidak ada akun yang cocok dengan pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="users-pagination">
            {{ $users->links() }}
        </div>
    </section>
</div>

<div class="users-modal" id="userModal" role="dialog" aria-modal="true" aria-labelledby="userModalTitle">
    <div class="users-modal-box">
        <div class="users-modal-head">
            <h2 id="userModalTitle">Tambah Anggota</h2>
            <button class="users-close" type="button" onclick="closeUserModal()" aria-label="Tutup">&times;</button>
        </div>

        <form id="userForm" method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div id="editMethod"></div>

            <div class="users-field">
                <label for="userName">Nama lengkap</label>
                <input class="users-input" id="userName" name="name" required maxlength="255">
            </div>

            <div class="users-form-grid">
                <div class="users-field">
                    <label for="userUsername">Username</label>
                    <input class="users-input" id="userUsername" name="username" required maxlength="50" pattern="[A-Za-z0-9_-]+">
                </div>

                <div class="users-field">
                    <label for="userEmail">Email</label>
                    <input class="users-input" id="userEmail" type="email" name="email" required maxlength="255">
                </div>
            </div>

            
            
<div id="passwordFields">
    <div class="users-field">
        <label for="userPassword">Password awal</label>
        <input
            class="users-input"
            id="userPassword"
            type="password"
            name="password"
            minlength="8"
            autocomplete="new-password"
        >
    </div>

            <div class="users-field">
                <label for="userPasswordConfirmation">Konfirmasi password</label>
                <input
                    class="users-input"
                    id="userPasswordConfirmation"
                    type="password"
                    name="password_confirmation"
                    minlength="8"
                    autocomplete="new-password"
                    aria-describedby="passwordMatchError"
                >

                <small
                    id="passwordMatchError"
                    style="display:none;color:#ff9ca7;font-size:12px;"
                >
                    Password dan konfirmasi password tidak sama.
                </small>
            </div>
        </div>

            <div class="users-field">
                <label for="userRole">Role akses</label>
                <select class="users-select" id="userRole" name="role" required style="width:100%;">
                    <option value="anggota">Anggota</option>
                    <option value="lead">Lead</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div class="users-modal-actions">
                <button type="button" class="users-btn users-btn-secondary" onclick="closeUserModal()">Batal</button>
                <button type="submit" class="users-btn" id="userSubmit">Simpan Akun</button>
            </div>
        </form>
    </div>
</div>

<script>
    const userModal = document.getElementById('userModal');
    const userForm = document.getElementById('userForm');
    const editMethod = document.getElementById('editMethod');
    const passwordFields = document.getElementById('passwordFields');
    const passwordInput = document.getElementById('userPassword');
    const passwordConfirmation = document.getElementById('userPasswordConfirmation');

    
    function openUserModal() {
        userForm.reset();

        userForm.action = @json(route('admin.users.store'));
        editMethod.innerHTML = '';

        passwordFields.style.display = '';
        passwordInput.required = true;
        passwordConfirmation.required = true;

        document.getElementById('userModalTitle').textContent = 'Tambah Anggota';
        document.getElementById('userSubmit').textContent = 'Simpan Akun';

        userModal.classList.add('open');
    }

    function openEditModal(button) {
        userForm.reset();

        const id = button.dataset.id;
        userForm.action = @json(url('/admin/users')) + '/' + encodeURIComponent(id);
        editMethod.innerHTML = '<input type="hidden" name="_method" value="PUT">';

        document.getElementById('userName').value = button.dataset.name;
        document.getElementById('userUsername').value = button.dataset.username;
        document.getElementById('userEmail').value = button.dataset.email;
        document.getElementById('userRole').value = button.dataset.role;

        passwordFields.style.display = 'none';
        passwordInput.required = false;
        passwordConfirmation.required = false;

        document.getElementById('userModalTitle').textContent = 'Edit Anggota';
        document.getElementById('userSubmit').textContent = 'Simpan Perubahan';
        userModal.classList.add('open');
    }

    function closeUserModal() {
        userModal.classList.remove('open');
    }

    userModal.addEventListener('click', function (event) {
        if (event.target === userModal) closeUserModal();
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') closeUserModal();
    });
    
function validatePasswordMatch() {
    // Validasi hanya berlaku saat modal tambah akun dibuka.
    const isCreatingUser =
        userForm.action === @json(route('admin.users.store'));

    const errorElement = document.getElementById('passwordMatchError');

    if (!isCreatingUser) {
        errorElement.style.display = 'none';
        passwordConfirmation.setCustomValidity('');
        return true;
    }

    const password = passwordInput.value;
    const confirmation = passwordConfirmation.value;
    const mismatch =
        confirmation.length > 0 && password !== confirmation;

    errorElement.style.display = mismatch ? 'block' : 'none';

    passwordConfirmation.setCustomValidity(
        mismatch ? 'Password dan konfirmasi password tidak sama.' : ''
    );

    return !mismatch;
}

passwordInput.addEventListener('input', validatePasswordMatch);
passwordConfirmation.addEventListener('input', validatePasswordMatch);

userForm.addEventListener('submit', function (event) {
    if (!validatePasswordMatch()) {
        event.preventDefault();
        passwordConfirmation.focus();
    }
});
</script>
@endsection