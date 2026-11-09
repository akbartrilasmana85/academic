@extends('layouts.admin')

@section('judul', 'Edit Mahasiswa')

@section('konten')
    <h1>Edit Mahasiswa</h1>

    <div class="kartu">
        <form action="{{ route('admin.mahasiswa.update', $mahasiswa) }}" method="POST">
            @csrf
            @method('PUT')
            @include('mahasiswa._form')

            <div class="tombol">
                <button type="submit" class="btn btn-primary">Perbarui</button>
                <a href="{{ route('admin.mahasiswa.show', $mahasiswa) }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
