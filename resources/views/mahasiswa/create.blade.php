@extends('layouts.admin')

@section('judul', 'Tambah Mahasiswa')

@section('konten')
    <h1>Tambah Mahasiswa</h1>

    <div class="kartu">
        <form action="{{ route('admin.mahasiswa.store') }}" method="POST">
            @csrf
            @include('mahasiswa._form')

            <div class="tombol">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
