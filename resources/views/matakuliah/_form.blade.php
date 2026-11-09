@php
    // dipakai create (tanpa $matakuliah) dan edit (dengan $matakuliah)
    $nilai = $matakuliah ?? new \App\Models\MataKuliah();
@endphp

<div class="field">
    <label for="kode">Kode</label>
    <input type="text" id="kode" name="kode" value="{{ old('kode', $nilai->kode) }}">
    @error('kode') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="field">
    <label for="nama">Nama Mata Kuliah</label>
    <input type="text" id="nama" name="nama" value="{{ old('nama', $nilai->nama) }}">
    @error('nama') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="field">
    <label for="sks">SKS</label>
    <input type="number" id="sks" name="sks" value="{{ old('sks', $nilai->sks) }}">
    @error('sks') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="field">
    <label for="semester_rekomendasi">Semester Rekomendasi (opsional)</label>
    <input type="number" id="semester_rekomendasi" name="semester_rekomendasi"
           value="{{ old('semester_rekomendasi', $nilai->semester_rekomendasi) }}">
    @error('semester_rekomendasi') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="field">
    <label>
        {{-- kalau habis gagal validasi, pakai nilai dari form; kalau tidak, pakai nilai data --}}
        <input type="checkbox" name="aktif" value="1"
            @checked(session()->hasOldInput() ? old('aktif') : ($nilai->aktif ?? true))>
        Aktif
    </label>
</div>
