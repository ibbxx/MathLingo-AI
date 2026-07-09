# Update: Quiz Admin (Multiple Choice / Essay Susun Kata) + Halaman Quiz Siswa

Cara pakai: extract/timpa (overwrite) file-file di zip ini ke folder project
Laravel kamu (struktur foldernya sudah sama persis, tinggal replace).

## 1. Jalankan migration baru
Menambahkan kolom `image` (nullable) ke tabel `quizzes`, untuk gambar
opsional pada soal Multiple Choice.

```
php artisan migrate
```

## 2. Pastikan storage link sudah ada
Supaya gambar soal bisa diakses publik (sama seperti thumbnail kursus):

```
php artisan storage:link
```

## Apa yang berubah

### A. Panel Admin — Tambah/Edit Soal Quiz (`admin/quizzes/_form.blade.php`)
- Tipe Soal sekarang **hanya 2 pilihan**: **Multiple Choice** dan
  **Essay (Susun Kata)**.
- Field yang tampil otomatis berubah sesuai tipe yang dipilih:
  - **Multiple Choice**: builder opsi jawaban dinamis (tambah/hapus opsi,
    klik lingkaran untuk menandai jawaban benar) + **upload gambar
    opsional** untuk soal.
  - **Essay (Susun Kata)**: builder Word Bank (tambah kata satu per satu,
    termasuk kata pengecoh) lalu susun jawaban benar dengan klik kata
    sesuai urutan (mirip Duolingo).
  - XP Reward, Batas Waktu, Sort Order, dan Status tetap selalu tampil
    untuk kedua tipe.
- Data lama dengan tipe `essay` (essay bebas versi lama) tetap bisa
  dibuka di form edit; jika mengandung word bank akan otomatis
  diperlakukan sebagai Susun Kata.

Tidak ada perubahan pada `StoreQuizRequest` / `UpdateQuizRequest` untuk
`options_raw` dan `correct_answer_order[]` — keduanya memang sudah
mendukung alur Susun Kata sebelumnya, form baru ini hanya menyediakan
UI yang lebih baik untuk mengisinya. Yang baru ditambahkan hanyalah
validasi `image` (nullable, image, maks 2MB) dan `remove_image`.

### B. Panel Siswa — Halaman Quiz (`resources/views/quiz/*`, `StudentQuizController`)
Alur baru, 3 tingkat:

1. **`/quiz`** — Kartu per **Pelajaran** (mirip halaman Kursus), hanya
   menampilkan pelajaran yang punya minimal 1 soal aktif. Setiap kartu
   menunjukkan jumlah soal Multiple Choice & Essay (Susun Kata).
2. **`/quiz/lesson/{lesson}`** — Setelah klik kartu pelajaran, siswa
   melihat daftar soal pelajaran tsb, dikelompokkan lewat tab
   **Multiple Choice** / **Essay (Susun Kata)**, sehingga siswa memilih
   sendiri mau mengerjakan tipe yang mana.
3. **`/quiz/{quiz}`** — Halaman mengerjakan 1 soal:
   - Multiple Choice: tampilkan gambar (jika ada) + opsi jawaban,
     periksa jawaban via AJAX ke endpoint yang sudah ada
     (`/quiz/{quiz}/check-answer`).
   - Essay (Susun Kata): pakai ulang partial yang sudah ada
     (`quiz/partial/word-arrange-question.blade.php`) — klik kata dari
     word bank untuk menyusun jawaban.

Route baru ditambahkan di `routes/web.php`:
```
Route::get('/quiz/lesson/{lesson}', [StudentQuizController::class, 'lesson'])->name('quiz.lesson');
```

### C. Model `Quiz`
- Tambah `image` ke `$fillable` + accessor `image_url`.
- Tambah accessor `is_word_arrange` (true untuk tipe `word_arrange`,
  juga true untuk data lama bertipe `essay` yang kebetulan sudah punya
  word bank) supaya logic Susun Kata konsisten di admin & siswa.
- Label tipe soal (`question_type_label`) disatukan jadi
  "Essay (Susun Kata)" untuk `word_arrange` maupun `essay`.

## Catatan
- Soal lama (id=1 di data kamu) bertipe `essay` tanpa word bank tetap
  aman ditampilkan (ada fallback pesan di halaman siswa), tapi
  sebaiknya diubah manual lewat form edit menjadi Multiple Choice atau
  Essay (Susun Kata) supaya bisa dikerjakan interaktif oleh siswa.
