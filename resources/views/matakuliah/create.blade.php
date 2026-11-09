@extends('layouts.admin')

@section('judul', 'Tambah Mata Kuliah')

@section('konten')
    <h1>Tambah Mata Kuliah</h1>

    <div class="kartu">
        <form action="{{ route('admin.matakuliah.store') }}" method="POST">
            @csrf
            @include('matakuliah._form')

            <div class="tombol">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.matakuliah.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
