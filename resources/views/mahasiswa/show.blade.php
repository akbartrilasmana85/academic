@extends('layouts.admin')

@section('judul', 'Detail Mahasiswa')

@section('konten')
    <h1>Detail Mahasiswa</h1>

    <div class="kartu">
        <p><strong>NIM:</strong> {{ $mahasiswa->nim }}</p>
        <p><strong>Nama:</strong> {{ $mahasiswa->nama }}</p>
        <p><strong>Email:</strong> {{ $mahasiswa->email }}</p>
        <p><strong>Angkatan:</strong> {{ $mahasiswa->angkatan }}</p>
        <p><strong>Status:</strong> {{ $mahasiswa->aktif ? 'Aktif' : 'Nonaktif' }}</p>
    </div>

    <div class="tombol">
        <a href="{{ route('admin.mahasiswa.edit', $mahasiswa) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-secondary">Kembali</a>

        <form action="{{ route('admin.mahasiswa.destroy', $mahasiswa) }}" method="POST"
              onsubmit="return confirm('Yakin hapus data {{ $mahasiswa->nama }}?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
    </div>
@endsection
