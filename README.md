# Mini Project - Academic (Master Data Bangun)

Modul master data akademik dengan dua resource: **Mahasiswa** dan **Mata Kuliah**.

## Ringkasan implementasi

| Poin tugas | Implementasi |
|---|---|
| Route::resource untuk kedua resource | `routes/web.php`: `Route::resource('mahasiswa', ...)` dan `Route::resource('matakuliah', ...)` |
| Route model binding | parameter `Mahasiswa $mahasiswa` dan `MataKuliah $matakuliah` di controller |
| Named route dari resource | `admin.mahasiswa.*` dan `admin.matakuliah.*` (dipakai di Blade dengan `route()`) |
| Prefix /admin | `Route::prefix('admin')->name('admin.')` |
| Migration dan Eloquent | `database/migrations/` (tabel `mahasiswas`, `mata_kuliahs`), model di `app/Models/` |
| Validasi create dan update | `validasi()` di masing-masing controller, dengan `Rule::unique()->ignore()` saat update |
| Blade index/create/show/edit | `resources/views/mahasiswa/` dan `resources/views/matakuliah/`, layout di `layouts/admin.blade.php` |
| Flash message | `->with('success', ...)` di controller, ditampilkan di layout |
| Konfirmasi delete | `onsubmit="return confirm(...)"` pada form hapus |
| Dokumentasi route:list | bagian "Hasil route:list" di bawah |
| Uji skenario CRUD | `tests/Feature/MahasiswaCrudTest.php` dan `MataKuliahCrudTest.php` |

## Setup

```bash
composer create-project laravel/laravel:^12.0 academic
cd academic
# salin folder app/, database/, routes/, resources/, tests/, README.md dari paket ini, timpa yang ada
composer dump-autoload
php artisan migrate
php artisan serve
```

Buka `http://127.0.0.1:8000/admin/mahasiswa` atau `http://127.0.0.1:8000/admin/matakuliah`.

## Cara uji

```bash
php artisan test
```

Hasil yang diharapkan: semua test di `MahasiswaCrudTest` dan `MataKuliahCrudTest` berstatus passed.

## Hasil php artisan route:list

Jalankan perintah ini, lalu tempel outputnya di bawah:

```bash
php artisan route:list --path=admin
```

```
GET|HEAD        admin/mahasiswa ................................................................................................................... admin.mahasiswa.index › MahasiswaController@index
  POST            admin/mahasiswa ................................................................................................................... admin.mahasiswa.store › MahasiswaController@store
  GET|HEAD        admin/mahasiswa/create .......................................................................................................... admin.mahasiswa.create › MahasiswaController@create
  GET|HEAD        admin/mahasiswa/{mahasiswa} ......................................................................................................... admin.mahasiswa.show › MahasiswaController@show
  PUT|PATCH       admin/mahasiswa/{mahasiswa} ..................................................................................................... admin.mahasiswa.update › MahasiswaController@update
  DELETE          admin/mahasiswa/{mahasiswa} ................................................................................................... admin.mahasiswa.destroy › MahasiswaController@destroy
  GET|HEAD        admin/mahasiswa/{mahasiswa}/edit .................................................................................................... admin.mahasiswa.edit › MahasiswaController@edit
  GET|HEAD        admin/matakuliah ................................................................................................................ admin.matakuliah.index › MataKuliahController@index
  POST            admin/matakuliah ................................................................................................................ admin.matakuliah.store › MataKuliahController@store
  GET|HEAD        admin/matakuliah/create ....................................................................................................... admin.matakuliah.create › MataKuliahController@create
  GET|HEAD        admin/matakuliah/{matakuliah} ..................................................................................................... admin.matakuliah.show › MataKuliahController@show
  PUT|PATCH       admin/matakuliah/{matakuliah} ................................................................................................. admin.matakuliah.update › MataKuliahController@update
  DELETE          admin/matakuliah/{matakuliah} ............................................................................................... admin.matakuliah.destroy › MataKuliahController@destroy
  GET|HEAD        admin/matakuliah/{matakuliah}/edit ................................................................................................ admin.matakuliah.edit › MataKuliahController@edit

                                                 
```

## Checklist uji manual CRUD

Lakukan langkah ini di browser setelah `php artisan serve` berjalan:

- [✓] **Mahasiswa, tambah:** buka Tambah Mahasiswa, isi data valid, simpan. Harus redirect ke halaman detail dan muncul pesan sukses.
- [✓] **Mahasiswa, validasi tambah:** kirim form kosong. Harus muncul pesan error di setiap field wajib.
- [✓] **Mahasiswa, NIM duplikat:** tambah mahasiswa dengan NIM yang sudah ada. Harus muncul error NIM.
- [✓] **Mahasiswa, lihat:** klik Lihat dari daftar. Detail harus sesuai data.
- [✓] **Mahasiswa, edit:** ubah nama lalu perbarui. Harus muncul pesan sukses dan data berubah.
- [✓] **Mahasiswa, edit tanpa ganti NIM:** perbarui tanpa mengubah NIM atau email. Tidak boleh ada error duplikat.
- [✓] **Mahasiswa, hapus batal:** klik Hapus lalu Cancel. Data tetap ada.
- [✓] **Mahasiswa, hapus:** klik Hapus lalu OK. Data hilang dan muncul pesan sukses.
- [✓] **Mata kuliah:** ulangi langkah yang sama untuk tambah, validasi, lihat, edit, dan hapus.
- [✓] **Mata kuliah, SKS:** isi SKS di luar 1 sampai 6. Harus muncul error SKS.

## Struktur penting

```
app/Http/Controllers/MahasiswaController.php
app/Http/Controllers/MataKuliahController.php
app/Models/Mahasiswa.php
app/Models/MataKuliah.php
database/migrations/2026_11_08_000001_create_mahasiswas_table.php
database/migrations/2026_11_08_000002_create_mata_kuliahs_table.php
database/factories/MahasiswaFactory.php
database/factories/MataKuliahFactory.php
routes/web.php
resources/views/layouts/admin.blade.php
resources/views/mahasiswa/   (index, create, show, edit, _form)
resources/views/matakuliah/  (index, create, show, edit, _form)
tests/Feature/MahasiswaCrudTest.php
tests/Feature/MataKuliahCrudTest.php
```

## Catatan

- Mahasiswa dan mata kuliah dibuat sebagai dua tabel terpisah tanpa relasi, sesuai cakupan tugas minimal. Relasi KRS dan program studi bisa ditambahkan di tahap berikutnya.
- Konfigurasi default Laravel 12 memakai SQLite. Pastikan `DB_CONNECTION=sqlite` di `.env` agar migration dan test berjalan tanpa server database terpisah.
