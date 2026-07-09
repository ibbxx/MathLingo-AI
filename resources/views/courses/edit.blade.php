<x-app-layout>

@section('page-title', 'Edit Kursus')

<style>
    /* ─── DESIGN TOKENS ───────────────────────────────────── */
    :root {
        --primary:   #2563EB;
        --p10:       #EFF6FF;
        --p20:       #DBEAFE;
        --secondary: #22C55E;
        --s10:       #F0FDF4;
        --accent:    #F59E0B;
        --a10:       #FFFBEB;
        --danger:    #EF4444;
        --bg:        #F8FAFC;
        --surface:   #FFFFFF;
        --border:    #E5E7EB;
        --text:      #1E293B;
        --muted:     #64748B;
        --r-card:    20px;
        --shadow:    0 1px 3px rgba(0,0,0,0.06),0 4px 16px rgba(0,0,0,0.05);
    }

    .section-fade { opacity:0; animation:fadeUp 0.45s cubic-bezier(0.22,1,0.36,1) forwards; }
    @keyframes fadeUp {
        from { opacity:0; transform:translateY(18px); }
        to   { opacity:1; transform:translateY(0); }
    }
    .d1{animation-delay:0.05s;} .d2{animation-delay:0.12s;}

    /* ─── PAGE HEADER ─────────────────────────────────────── */
    .page-hero {
        background: var(--primary);
        border-radius: var(--r-card);
        padding: 28px 32px;
        position: relative;
        overflow: hidden;
    }
    .page-hero::before {
        content:''; position:absolute; top:-60px; right:-60px;
        width:200px; height:200px; border-radius:50%;
        background:rgba(255,255,255,0.05); pointer-events:none;
    }
    .breadcrumb {
        display:flex; align-items:center; gap:6px;
        font-size:13px; font-weight:500; color:rgba(255,255,255,0.6);
        margin-bottom:8px; position:relative; z-index:1;
    }
    .breadcrumb a { color:rgba(255,255,255,0.6); text-decoration:none; }
    .breadcrumb a:hover { color:#fff; }
    .page-hero-title {
        font-size:22px; font-weight:800; color:#fff;
        letter-spacing:-0.4px; margin:0 0 4px; position:relative; z-index:1;
    }
    .page-hero-sub {
        font-size:13px; color:rgba(255,255,255,0.7);
        line-height:1.6; margin:0; position:relative; z-index:1;
    }

    /* ─── CARD ────────────────────────────────────────────── */
    .card {
        background: var(--surface);
        border-radius: var(--r-card);
        box-shadow: var(--shadow);
        overflow: hidden;
    }
    .card-header {
        display:flex; align-items:center; justify-content:space-between;
        padding: 22px 28px 18px;
        border-bottom: 1px solid var(--border);
    }
    .card-header-left { display:flex; align-items:center; gap:10px; }
    .card-icon {
        width:34px; height:34px; border-radius:9px;
        display:flex; align-items:center; justify-content:center;
    }
    .card-title { font-size:15px; font-weight:700; color:var(--text); }
    .card-body  { padding: 24px 28px; }

    /* ─── FORM ────────────────────────────────────────────── */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }
    .form-group { display:flex; flex-direction:column; gap:6px; }
    .form-group.full { grid-column: 1 / -1; }

    .form-label {
        font-size:13px; font-weight:600; color:var(--text);
    }
    .form-label .req { color:var(--danger); margin-left:2px; }
    .form-hint { font-size:12px; color:var(--muted); line-height:1.4; margin-top:2px; }

    .form-input,
    .form-select,
    .form-textarea {
        width:100%; padding: 10px 14px;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        font-size: 14px; font-family: inherit;
        color: var(--text); background: var(--bg);
        outline: none;
        transition: border-color 0.15s, box-shadow 0.15s;
        appearance: none;
    }
    .form-input:focus, .form-select:focus, .form-textarea:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        background: #fff;
    }
    .form-input::placeholder, .form-textarea::placeholder { color:var(--muted); }
    .form-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748B' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 36px; cursor: pointer;
    }
    .form-textarea { resize:vertical; min-height:100px; line-height:1.6; }

    .form-error {
        font-size:12px; font-weight:600; color:var(--danger);
        display:flex; align-items:center; gap:4px; margin-top:2px;
    }
    .form-input.error, .form-select.error, .form-textarea.error {
        border-color: var(--danger);
        box-shadow: 0 0 0 3px rgba(239,68,68,0.1);
    }

    /* Color picker */
    .color-picker-wrap { display:flex; align-items:center; gap:10px; }
    .color-picker-preview {
        width:38px; height:38px; border-radius:9px;
        border:1.5px solid var(--border); flex-shrink:0;
    }
    .color-input-native {
        width:38px; height:38px; border:none; background:none;
        padding:0; cursor:pointer; border-radius:9px;
        opacity:0; position:absolute;
    }
    .color-hex-input {
        flex:1; padding: 10px 14px;
        border: 1.5px solid var(--border); border-radius: 10px;
        font-size: 14px; font-family: 'Courier New', monospace;
        color: var(--text); background: var(--bg); outline: none;
        transition: border-color 0.15s; text-transform: uppercase;
    }
    .color-hex-input:focus { border-color:var(--primary); }
    .color-presets { display:flex; gap:6px; flex-wrap:wrap; margin-top:8px; }
    .color-preset {
        width:26px; height:26px; border-radius:7px;
        cursor:pointer; border:2px solid transparent;
        transition:border-color 0.12s, transform 0.12s; flex-shrink:0;
    }
    .color-preset:hover { transform:scale(1.1); border-color:rgba(0,0,0,0.1); }

    /* Toggle switch */
    .toggle-wrap { display:flex; align-items:center; gap:12px; }
    .toggle-switch { position:relative; width:44px; height:24px; flex-shrink:0; }
    .toggle-switch input { opacity:0; width:0; height:0; }
    .toggle-slider {
        position:absolute; cursor:pointer;
        inset:0; background:#E2E8F0; border-radius:99px;
        transition:background 0.2s;
    }
    .toggle-slider::before {
        content:''; position:absolute;
        width:18px; height:18px; border-radius:50%;
        background:#fff; left:3px; top:3px;
        transition:transform 0.2s;
        box-shadow:0 1px 4px rgba(0,0,0,0.15);
    }
    .toggle-switch input:checked + .toggle-slider { background:var(--secondary); }
    .toggle-switch input:checked + .toggle-slider::before { transform:translateX(20px); }
    .toggle-label { font-size:14px; font-weight:500; color:var(--text); }

    /* Error alert */
    .alert-error {
        display:flex; align-items:flex-start; gap:10px;
        padding:14px 16px; border-radius:12px;
        background:#FEF2F2; border:1.5px solid #FECACA; margin-bottom:20px;
    }
    .alert-error-icon { color:var(--danger); flex-shrink:0; margin-top:1px; }
    .alert-error-body { flex:1; }
    .alert-error-title { font-size:13px; font-weight:700; color:var(--danger); margin-bottom:4px; }
    .alert-error-list { font-size:12px; color:#991B1B; list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:2px; }

    /* Form actions */
    .form-actions {
        display:flex; align-items:center; gap:10px;
        flex-wrap:wrap;
        padding-top:20px; border-top:1px solid var(--border); margin-top:4px;
    }
    .btn-submit {
        display:inline-flex; align-items:center; gap:7px;
        padding:11px 24px; background:var(--primary); color:#fff;
        font-size:14px; font-weight:700; font-family:inherit;
        border-radius:10px; border:none; cursor:pointer; transition:opacity 0.15s;
    }
    .btn-submit:hover { opacity:0.88; }
    .btn-cancel {
        display:inline-flex; align-items:center; gap:7px;
        padding:11px 18px; background:var(--bg); color:var(--muted);
        font-size:14px; font-weight:600;
        border-radius:10px; border:1.5px solid var(--border);
        text-decoration:none; transition:border-color 0.15s, color 0.15s;
    }
    .btn-cancel:hover { border-color:var(--primary); color:var(--primary); }
    .btn-view {
        display:inline-flex; align-items:center; gap:7px;
        padding:11px 18px; background:var(--s10); color:#15803D;
        font-size:14px; font-weight:600;
        border-radius:10px; border:1.5px solid #BBF7D0;
        text-decoration:none; transition:background 0.15s;
        margin-left:auto;
    }
    .btn-view:hover { background:#D1FAE5; }

    @media (max-width:767px) {
        .form-grid { grid-template-columns:1fr; }
        .form-group.full { grid-column:1; }
        .card-body { padding:20px; }
        .btn-view { margin-left:0; }
    }
</style>

@php $courseColor = old('color', $course->color ?? '#2563EB'); @endphp

<div style="max-width:800px;margin:0 auto;display:flex;flex-direction:column;gap:20px;">

    {{-- Hero --}}
    <div class="section-fade d1">
        <div class="page-hero">
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}">Dasbor</a>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                <a href="{{ route('courses.index') }}">Kursus</a>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                <a href="{{ route('courses.show', $course->slug) }}" style="color:rgba(255,255,255,0.7);">{{ $course->title }}</a>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                <span style="color:rgba(255,255,255,0.9);">Edit</span>
            </div>
            <h1 class="page-hero-title">Edit Kursus</h1>
            <p class="page-hero-sub">Update details for: <strong style="color:#fff;">{{ $course->title }}</strong></p>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="section-fade d2">
        <div class="card">
            <div class="card-header">
                <div class="card-header-left">
                    <div class="card-icon" style="background:{{ $courseColor }}1A;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="{{ $courseColor }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                        </svg>
                    </div>
                    <span class="card-title">Detail Kursus</span>
                </div>
                <a href="{{ route('courses.show', $course->slug) }}" class="btn-view">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                    </svg>
                    Lihat Kursus
                </a>
            </div>
            <div class="card-body">

                {{-- Error alert --}}
                @if($errors->any())
                <div class="alert-error">
                    <div class="alert-error-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                    </div>
                    <div class="alert-error-body">
                        <div class="alert-error-title">Mohon perbaiki kesalahan berikut:</div>
                        <ul class="alert-error-list">
                            @foreach($errors->all() as $error)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <form method="POST" action="{{ route('courses.update', $course) }}">
                    @csrf
                    @method('PATCH')
                    <div class="form-grid">

                        {{-- Title --}}
                        <div class="form-group full">
                            <label class="form-label" for="title">
                                Judul Kursus <span class="req">*</span>
                            </label>
                            <input
                                type="text"
                                id="title"
                                name="title"
                                class="form-input {{ $errors->has('title') ? 'error' : '' }}"
                                value="{{ old('title', $course->title) }}"
                                placeholder="e.g. Mathematical Vocabulary — Algebra"
                                required
                            >
                            @error('title')
                                <span class="form-error">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        {{-- Slug --}}
                        <div class="form-group full">
                            <label class="form-label" for="slug">
                                Slug <span class="req">*</span>
                            </label>
                            <input
                                type="text"
                                id="slug"
                                name="slug"
                                class="form-input {{ $errors->has('slug') ? 'error' : '' }}"
                                value="{{ old('slug', $course->slug) }}"
                                required
                                style="font-family:'Courier New',monospace;font-size:13px;"
                            >
                            <span class="form-hint">URL saat ini: <code style="background:var(--bg);padding:1px 5px;border-radius:4px;font-size:12px;">/courses/{{ $course->slug }}</code></span>
                            @error('slug')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="form-group full">
                            <label class="form-label" for="description">Deskripsi</label>
                            <textarea
                                id="description"
                                name="description"
                                class="form-textarea {{ $errors->has('description') ? 'error' : '' }}"
                                placeholder="Deskripsikan apa yang akan dipelajari siswa..."
                            >{{ old('description', $course->description) }}</textarea>
                            @error('description')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Difficulty --}}
                        <div class="form-group">
                            <label class="form-label" for="difficulty">
                                Tingkat Kesulitan <span class="req">*</span>
                            </label>
                            <select
                                id="difficulty"
                                name="difficulty"
                                class="form-select {{ $errors->has('difficulty') ? 'error' : '' }}"
                                required
                            >
                                <option value="">Pilih tingkat kesulitan</option>
                                <option value="beginner"     {{ old('difficulty', $course->difficulty) === 'beginner'     ? 'selected' : '' }}>Pemula</option>
                                <option value="intermediate" {{ old('difficulty', $course->difficulty) === 'intermediate' ? 'selected' : '' }}>Menengah</option>
                                <option value="advanced"     {{ old('difficulty', $course->difficulty) === 'advanced'     ? 'selected' : '' }}>Lanjutan</option>
                            </select>
                            @error('difficulty')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Icon --}}
                        <div class="form-group">
                            <label class="form-label" for="icon">Ikon (opsional)</label>
                            <input
                                type="text"
                                id="icon"
                                name="icon"
                                class="form-input"
                                value="{{ old('icon', $course->icon) }}"
                                placeholder="e.g. calculator, sigma, pi"
                            >
                        </div>

                        {{-- Total XP --}}
                        <div class="form-group">
                            <label class="form-label" for="total_xp">Total XP</label>
                            <input
                                type="number"
                                id="total_xp"
                                name="total_xp"
                                class="form-input {{ $errors->has('total_xp') ? 'error' : '' }}"
                                value="{{ old('total_xp', $course->total_xp) }}"
                                min="0" step="10"
                            >
                            @error('total_xp')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Urutan Tampil --}}
                        <div class="form-group">
                            <label class="form-label" for="sort_order">Urutan Tampil</label>
                            <input
                                type="number"
                                id="sort_order"
                                name="sort_order"
                                class="form-input {{ $errors->has('sort_order') ? 'error' : '' }}"
                                value="{{ old('sort_order', $course->sort_order) }}"
                                min="0"
                            >
                            <span class="form-hint">Angka lebih kecil tampil lebih awal.</span>
                            @error('sort_order')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Color --}}
                        <div class="form-group full">
                            <label class="form-label" for="color_hex">Warna Kursus</label>
                            <div class="color-picker-wrap">
                                <div style="position:relative;flex-shrink:0;">
                                    <div class="color-picker-preview" id="colorPreview" style="background:{{ $courseColor }};"></div>
                                    <input type="color" class="color-input-native" id="colorNative" value="{{ $courseColor }}" oninput="syncColor(this.value)">
                                </div>
                                <input
                                    type="text"
                                    id="color_hex"
                                    name="color"
                                    class="color-hex-input"
                                    value="{{ $courseColor }}"
                                    placeholder="#2563EB"
                                    maxlength="7"
                                    oninput="syncColorFromHex(this.value)"
                                >
                            </div>
                            <div class="color-presets">
                                @foreach(['#2563EB','#22C55E','#F59E0B','#EF4444','#8B5CF6','#06B6D4','#EC4899','#0EA5E9','#10B981','#F97316'] as $col)
                                <button type="button" class="color-preset" style="background:{{ $col }};" onclick="syncColor('{{ $col }}')" title="{{ $col }}"></button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="form-group full">
                            <label class="form-label">Status</label>
                            <div class="toggle-wrap">
                                <label class="toggle-switch">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" value="1" id="is_active"
                                        {{ old('is_active', $course->is_active ? '1' : '0') == '1' ? 'checked' : '' }}>
                                    <span class="toggle-slider"></span>
                                </label>
                                <span class="toggle-label">Aktif — terlihat oleh siswa</span>
                            </div>
                        </div>

                    </div>{{-- /form-grid --}}

                    <div class="form-actions">
                        <button type="submit" class="btn-submit">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('courses.show', $course->slug) }}" class="btn-cancel">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                            </svg>
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
function syncColor(hex) {
    const preview  = document.getElementById('colorPreview');
    const hexInput = document.getElementById('color_hex');
    const native   = document.getElementById('colorNative');
    if (!hex.startsWith('#')) hex = '#' + hex;
    if (preview)  preview.style.background = hex;
    if (hexInput) hexInput.value = hex.toUpperCase();
    if (native)   native.value  = hex;
}
function syncColorFromHex(hex) {
    if (!hex.startsWith('#')) return;
    if (hex.length === 7) syncColor(hex);
}
const preview = document.getElementById('colorPreview');
const native  = document.getElementById('colorNative');
if (preview && native) {
    preview.style.cursor = 'pointer';
    preview.addEventListener('click', function () { native.click(); });
}
</script>

</x-app-layout>