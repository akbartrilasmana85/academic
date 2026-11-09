@php
    // dipakai create (tanpa $mahasiswa) dan edit (dengan $mahasiswa)
    $nilai = $mahasiswa ?? new \App\Models\Mahasiswa();
@endphp

<div class="field">
    <label for="nim">NIM</label>
    <input type="text" id="nim" name="nim" value="{{ old('nim', $nilai->nim) }}">
    @error('nim') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="field">
    <label for="nama">Nama</label>
    <input type="text" id="nama" name="nama" value="{{ old('nama', $nilai->nama) }}">
    @error('nama') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="field">
    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="{{ old('email', $nilai->email) }}">
    @error('email') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="field">
    <label for="angkatan">Angkatan</label>
    <input type="number" id="angkatan" name="angkatan" value="{{ old('angkatan', $nilai->angkatan) }}">
    @error('angkatan') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="field">
    <label>
        {{-- kalau habis gagal validasi, pakai nilai dari form; kalau tidak, pakai nilai data --}}
        <input type="checkbox" name="aktif" value="1"
            @checked(session()->hasOldInput() ? old('aktif') : ($nilai->aktif ?? true))>
        Aktif
    </label>
</div>
