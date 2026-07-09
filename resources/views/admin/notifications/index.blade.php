<x-admin-layout title="Notifikasi">
@push('styles')
<style>
.admin-page { padding: 28px 28px 40px; max-width: 900px; }
.admin-page-header { margin-bottom: 24px; }
.admin-page-title { font-size: 22px; font-weight: 800; color: var(--color-text); margin: 0 0 4px; letter-spacing: -0.4px; }
.admin-page-sub   { font-size: 13.5px; color: var(--color-muted); margin: 0; }

.panel { background: var(--color-surface); border: 1px solid var(--color-border); border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.04); overflow: hidden; margin-bottom: 20px; }
.panel-header { padding: 18px 24px 16px; border-bottom: 1px solid var(--color-border); }
.panel-title { font-size: 14px; font-weight: 700; color: var(--color-text); }
.panel-body  { padding: 20px 24px; }

.form-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 16px; }
.form-label { font-size: 13px; font-weight: 600; color: var(--color-text); }
.form-label span { color: var(--color-danger); margin-left: 2px; }
.form-input, .form-select, .form-textarea {
    padding: 9px 12px; border: 1.5px solid var(--color-border); border-radius: 9px;
    font-size: 13.5px; font-family: inherit; color: var(--color-text);
    background: #FAFBFC; outline: none; transition: border-color 0.15s, box-shadow 0.15s;
}
.form-input:focus, .form-select:focus, .form-textarea:focus {
    border-color: var(--color-primary); box-shadow: 0 0 0 3px rgba(37,99,235,0.08); background: #fff;
}
.form-textarea { resize: vertical; min-height: 80px; }
.form-hint  { font-size: 12px; color: var(--color-muted); }
.form-error { font-size: 12px; color: var(--color-danger); font-weight: 600; }

.target-toggle { display:flex; gap:10px; margin-bottom: 4px; }
.target-option {
    flex:1; border:1.5px solid var(--color-border); border-radius:10px; padding:10px 12px;
    cursor:pointer; font-size:13px; font-weight:600; color:var(--color-muted); text-align:center;
    transition: border-color .15s, color .15s, background .15s;
}
.target-option.active { border-color: var(--color-primary); color: var(--color-primary); background: var(--color-primary-10); }

.user-checklist { max-height:220px; overflow-y:auto; border:1.5px solid var(--color-border); border-radius:10px; padding:8px; display:none; }
.user-checklist.visible { display:block; }
.user-check-row { display:flex; align-items:center; gap:8px; padding:6px 8px; border-radius:8px; font-size:13px; }
.user-check-row:hover { background:#F8FAFC; }

.btn-submit {
    padding: 10px 22px; border: none; border-radius: 10px; background: var(--color-primary); color: #fff;
    font-size: 13.5px; font-weight: 700; font-family: inherit; cursor: pointer;
    display: inline-flex; align-items: center; gap: 7px;
}

.history-row { display:flex; gap:14px; padding:14px 24px; border-bottom:1px solid var(--color-border); }
.history-row:last-child { border-bottom:none; }
.history-title { font-size:13.5px; font-weight:700; color:var(--color-text); }
.history-message { font-size:12.5px; color:var(--color-muted); margin-top:2px; }
.history-meta { font-size:11.5px; color:var(--color-muted); margin-top:6px; }
.empty-hint { padding:24px; text-align:center; font-size:13px; color:var(--color-muted); }
</style>
@endpush

<div class="admin-page">

    <div class="admin-page-header">
        <h1 class="admin-page-title">Notifikasi</h1>
        <p class="admin-page-sub">Kirim pengumuman ke siswa. Notifikasi akan langsung muncul di dashboard mereka.</p>
    </div>

    @if(session('success'))
    <div style="padding:12px 16px;background:#F0FDF4;border:1px solid #BBF7D0;color:#166534;border-radius:10px;font-size:13px;margin-bottom:16px;">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div style="padding:12px 16px;background:#FEF2F2;border:1px solid #FECACA;color:#991B1B;border-radius:10px;font-size:13px;margin-bottom:16px;">
        {{ session('error') }}
    </div>
    @endif

    <div class="panel">
        <div class="panel-header">
            <span class="panel-title">Kirim Pengumuman Baru</span>
        </div>
        <div class="panel-body">
            <form method="POST" action="{{ route('admin.notifications.store') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="title">Judul <span>*</span></label>
                    <input type="text" id="title" name="title" class="form-input" maxlength="150"
                           placeholder="Contoh: Pemeliharaan sistem malam ini" value="{{ old('title') }}" required>
                    @error('title')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="message">Pesan <span>*</span></label>
                    <textarea id="message" name="message" class="form-textarea" maxlength="500"
                              placeholder="Tulis isi pengumuman di sini..." required>{{ old('message') }}</textarea>
                    @error('message')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="url">Tautan (opsional)</label>
                    <input type="text" id="url" name="url" class="form-input"
                           placeholder="/courses atau https://..." value="{{ old('url') }}">
                    <div class="form-hint">Jika diisi, notifikasi bisa diklik siswa untuk membuka halaman ini.</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Kirim ke <span>*</span></label>
                    <div class="target-toggle">
                        <label class="target-option active" id="target-all-label">
                            <input type="radio" name="target" value="all" checked style="display:none;" onclick="toggleTarget(false)">
                            Semua Siswa
                        </label>
                        <label class="target-option" id="target-specific-label">
                            <input type="radio" name="target" value="specific" style="display:none;" onclick="toggleTarget(true)">
                            Siswa Tertentu
                        </label>
                    </div>
                    <div class="user-checklist" id="user-checklist">
                        @forelse($students as $student)
                        <label class="user-check-row">
                            <input type="checkbox" name="user_ids[]" value="{{ $student->id }}">
                            {{ $student->name }} <span style="color:var(--color-muted);">— {{ $student->email }}</span>
                        </label>
                        @empty
                        <div class="empty-hint">Belum ada siswa terdaftar.</div>
                        @endforelse
                    </div>
                    @error('user_ids')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn-submit">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    Kirim Pengumuman
                </button>
            </form>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <span class="panel-title">Riwayat Pengumuman</span>
        </div>
        @if($history->isEmpty())
        <div class="empty-hint">Belum ada pengumuman yang dikirim.</div>
        @else
        <div>
            @foreach($history as $item)
            <div class="history-row">
                <div style="flex:1;">
                    <div class="history-title">{{ $item['title'] }}</div>
                    <div class="history-message">{{ $item['message'] }}</div>
                    <div class="history-meta">
                        Dikirim ke {{ $item['recipients'] }} siswa &middot;
                        {{ $item['read_count'] }} sudah dibaca &middot;
                        {{ $item['sent_at']->diffForHumans() }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

</div>

<script>
function toggleTarget(showList) {
    document.getElementById('target-all-label').classList.toggle('active', !showList);
    document.getElementById('target-specific-label').classList.toggle('active', showList);
    document.getElementById('user-checklist').classList.toggle('visible', showList);
}
</script>

</x-admin-layout>
