<x-app-layout>

@section('page-title', 'Edit Kosakata')

<style>
    :root { --primary:#2563EB; --border:#E5E7EB; --text:#1E293B; --muted:#64748B; --surface:#FFFFFF; --r-card:16px; --shadow:0 1px 3px rgba(0,0,0,0.06),0 4px 16px rgba(0,0,0,0.05); --danger:#EF4444; --s10:#F0FDF4; }
    .form-card { background:var(--surface); border-radius:var(--r-card); box-shadow:var(--shadow); padding:24px; max-width:720px; }
    .form-title { font-size:18px; font-weight:800; color:var(--text); margin-bottom:20px; }
    .form-group { margin-bottom:16px; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    label { display:block; font-size:13px; font-weight:700; color:var(--text); margin-bottom:6px; }
    input[type=text], input[type=number], input[type=file], textarea, select {
        width:100%; padding:10px 12px; border:1.5px solid var(--border); border-radius:9px;
        font-size:14px; font-family:inherit; color:var(--text); background:#fff;
    }
    textarea { resize:vertical; min-height:70px; }
    .error-msg { color:var(--danger); font-size:12px; margin-top:4px; }
    .btn-primary { padding:11px 22px; background:var(--primary); color:#fff; font-size:14px; font-weight:700; border-radius:10px; border:none; cursor:pointer; }
    .btn-outline { padding:11px 18px; background:#F8FAFC; color:var(--muted); font-size:14px; font-weight:600; border-radius:10px; border:1.5px solid var(--border); text-decoration:none; }
    .audio-current { display:flex; align-items:center; gap:10px; font-size:13px; color:var(--muted); margin-bottom:8px; }
</style>

@if(session('success'))
<div style="background:var(--s10);color:#15803D;padding:12px 16px;border-radius:10px;font-size:13px;font-weight:600;margin-bottom:16px;max-width:720px;">
    {{ session('success') }}
</div>
@endif

<div class="form-card">
    <div class="form-title">Edit Kosakata: {{ $vocabulary->term }}</div>

    <form action="{{ route('admin.vocabulary.update', $vocabulary) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label>Kursus</label>
                <select id="course_id" onchange="filterLessons()">
                    @foreach($courses as $c)
                        <option value="{{ $c->id }}" @selected(old('course_id', $vocabulary->lesson->course_id) == $c->id)>{{ $c->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Lesson <span style="color:var(--danger);">*</span></label>
                <select name="lesson_id" id="lesson_id" required>
                    @foreach($lessons as $l)
                        <option value="{{ $l->id }}" data-course="{{ $l->course_id }}" @selected(old('lesson_id', $vocabulary->lesson_id) == $l->id)>{{ $l->title }}</option>
                    @endforeach
                </select>
                @error('lesson_id')<div class="error-msg">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="form-group">
            <label>Istilah (Term) <span style="color:var(--danger);">*</span></label>
            <input type="text" name="term" value="{{ old('term', $vocabulary->term) }}">
            @error('term')<div class="error-msg">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label>Makna Matematis</label>
            <textarea name="mathematical_meaning">{{ old('mathematical_meaning', $vocabulary->mathematical_meaning) }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Pelafalan (Pronunciation)</label>
                <input type="text" name="pronunciation" value="{{ old('pronunciation', $vocabulary->pronunciation) }}">
            </div>
            <div class="form-group">
                <label>Formula</label>
                <input type="text" name="formula" value="{{ old('formula', $vocabulary->formula) }}">
            </div>
        </div>

        <div class="form-group">
            <label>Contoh</label>
            <textarea name="example">{{ old('example', $vocabulary->example) }}</textarea>
        </div>

        <div class="form-group">
            <label>Contoh Kalimat</label>
            <textarea name="example_sentence">{{ old('example_sentence', $vocabulary->example_sentence) }}</textarea>
        </div>

        <div class="form-group">
            <label>Terjemahan</label>
            <input type="text" name="translation" value="{{ old('translation', $vocabulary->translation) }}">
        </div>

        <div class="form-group">
            <label>File Audio</label>
            @if($vocabulary->audio_path)
            <div class="audio-current">
                <audio controls src="{{ asset('storage/' . $vocabulary->audio_path) }}" style="height:32px;"></audio>
                <label style="font-weight:500;display:flex;align-items:center;gap:5px;margin:0;">
                    <input type="checkbox" name="remove_audio" value="1" style="width:auto;"> Hapus audio
                </label>
            </div>
            @endif
            <input type="file" name="audio" accept=".mp3,.wav,.ogg,.m4a">
            @error('audio')<div class="error-msg">{{ $message }}</div>@enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Tingkat Kesulitan <span style="color:var(--danger);">*</span></label>
                <select name="difficulty">
                    <option value="beginner" @selected(old('difficulty', $vocabulary->difficulty) === 'beginner')>Beginner</option>
                    <option value="intermediate" @selected(old('difficulty', $vocabulary->difficulty) === 'intermediate')>Intermediate</option>
                    <option value="advanced" @selected(old('difficulty', $vocabulary->difficulty) === 'advanced')>Advanced</option>
                </select>
                @error('difficulty')<div class="error-msg">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $vocabulary->sort_order) }}" min="0">
                @error('sort_order')<div class="error-msg">{{ $message }}</div>@enderror
            </div>
        </div>

        <div style="display:flex;gap:10px;margin-top:20px;">
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
            <a href="{{ route('admin.vocabulary.index') }}" class="btn-outline">Batal</a>
        </div>
    </form>
</div>

<script>
    const lessonOptions = Array.from(document.querySelectorAll('#lesson_id option'));
    function filterLessons() {
        const courseId = document.getElementById('course_id').value;
        const lessonSelect = document.getElementById('lesson_id');
        const current = lessonSelect.value;
        lessonSelect.innerHTML = '';
        lessonOptions.forEach(opt => {
            if (!courseId || opt.dataset.course === courseId) {
                const clone = opt.cloneNode(true);
                if (clone.value === current) clone.selected = true;
                lessonSelect.appendChild(clone);
            }
        });
    }
</script>

</x-app-layout>
