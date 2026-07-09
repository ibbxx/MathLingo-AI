<x-app-layout>

@section('page-title', 'Tambah Kosakata')

<style>
    :root { --primary:#2563EB; --p10:#EFF6FF; --border:#E5E7EB; --text:#1E293B; --muted:#64748B; --surface:#FFFFFF; --r-card:16px; --shadow:0 1px 3px rgba(0,0,0,0.06),0 4px 16px rgba(0,0,0,0.05); --danger:#EF4444; }
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
</style>

<div class="form-card">
    <div class="form-title">Tambah Kosakata Baru</div>

    <form action="{{ route('admin.vocabulary.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label>Kursus</label>
                <select id="course_id" onchange="filterLessons()">
                    <option value="">Pilih Kursus</option>
                    @foreach($courses as $c)
                        <option value="{{ $c->id }}" @selected(old('course_id', $selectedCourseId) == $c->id)>{{ $c->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Lesson <span style="color:var(--danger);">*</span></label>
                <select name="lesson_id" id="lesson_id" required>
                    <option value="">Pilih Lesson</option>
                    @foreach($lessons as $l)
                        <option value="{{ $l->id }}" data-course="{{ $l->course_id }}" @selected(old('lesson_id', $selectedLessonId) == $l->id)>{{ $l->title }}</option>
                    @endforeach
                </select>
                @error('lesson_id')<div class="error-msg">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="form-group">
            <label>Istilah (Term) <span style="color:var(--danger);">*</span></label>
            <input type="text" name="term" value="{{ old('term') }}" placeholder="mis. Integral">
            @error('term')<div class="error-msg">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label>Makna Matematis</label>
            <textarea name="mathematical_meaning" placeholder="Penjelasan makna dalam konteks matematika">{{ old('mathematical_meaning') }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Pelafalan (Pronunciation)</label>
                <input type="text" name="pronunciation" value="{{ old('pronunciation') }}" placeholder="mis. /ˈɪn.tɪ.ɡrəl/">
            </div>
            <div class="form-group">
                <label>Formula</label>
                <input type="text" name="formula" value="{{ old('formula') }}" placeholder="mis. ∫f(x)dx">
            </div>
        </div>

        <div class="form-group">
            <label>Contoh</label>
            <textarea name="example" placeholder="Contoh penggunaan istilah">{{ old('example') }}</textarea>
        </div>

        <div class="form-group">
            <label>Contoh Kalimat</label>
            <textarea name="example_sentence">{{ old('example_sentence') }}</textarea>
        </div>

        <div class="form-group">
            <label>Terjemahan</label>
            <input type="text" name="translation" value="{{ old('translation') }}">
        </div>

        <div class="form-group">
            <label>File Audio (opsional)</label>
            <input type="file" name="audio" accept=".mp3,.wav,.ogg,.m4a">
            @error('audio')<div class="error-msg">{{ $message }}</div>@enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Tingkat Kesulitan <span style="color:var(--danger);">*</span></label>
                <select name="difficulty">
                    <option value="beginner" @selected(old('difficulty') === 'beginner')>Beginner</option>
                    <option value="intermediate" @selected(old('difficulty') === 'intermediate')>Intermediate</option>
                    <option value="advanced" @selected(old('difficulty') === 'advanced')>Advanced</option>
                </select>
                @error('difficulty')<div class="error-msg">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $maxSortOrder + 1) }}" min="0">
                @error('sort_order')<div class="error-msg">{{ $message }}</div>@enderror
            </div>
        </div>

        <div style="display:flex;gap:10px;margin-top:20px;">
            <button type="submit" class="btn-primary">Simpan Kosakata</button>
            <a href="{{ route('admin.vocabulary.index') }}" class="btn-outline">Batal</a>
        </div>
    </form>
</div>

<script>
    const lessonOptions = Array.from(document.querySelectorAll('#lesson_id option'));
    function filterLessons() {
        const courseId = document.getElementById('course_id').value;
        const lessonSelect = document.getElementById('lesson_id');
        lessonSelect.innerHTML = '';
        lessonOptions.forEach(opt => {
            if (!opt.value || !courseId || opt.dataset.course === courseId) {
                lessonSelect.appendChild(opt.cloneNode(true));
            }
        });
    }
    if (document.getElementById('course_id').value) filterLessons();
</script>

</x-app-layout>
