@extends('layouts.admin')

@section('judul', 'Detail Mata Kuliah')

@section('konten')
    <h1>Detail Mata Kuliah</h1>

    <div class="kartu">
        <p><strong>Kode:</strong> {{ $matakuliah->kode }}</p>
        <p><strong>Nama:</strong> {{ $matakuliah->nama }}</p>
        <p><strong>SKS:</strong> {{ $matakuliah->sks }}</p>
        <p><strong>Semester Rekomendasi:</strong> {{ $matakuliah->semester_rekomendasi ?? '-' }}</p>
        <p><strong>Status:</strong> {{ $matakuliah->aktif ? 'Aktif' : 'Nonaktif' }}</p>
    </div>

    <div class="tombol">
        <a href="{{ route('admin.matakuliah.edit', $matakuliah) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('admin.matakuliah.index') }}" class="btn btn-secondary">Kembali</a>

        <form action="{{ route('admin.matakuliah.destroy', $matakuliah) }}" method="POST"
              onsubmit="return confirm('Yakin hapus mata kuliah {{ $matakuliah->nama }}?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
    </div>
@endsection
