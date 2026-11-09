@extends('layouts.admin')

@section('judul', 'Edit Mata Kuliah')

@section('konten')
    <h1>Edit Mata Kuliah</h1>

    <div class="kartu">
        <form action="{{ route('admin.matakuliah.update', $matakuliah) }}" method="POST">
            @csrf
            @method('PUT')
            @include('matakuliah._form')

            <div class="tombol">
                <button type="submit" class="btn btn-primary">Perbarui</button>
                <a href="{{ route('admin.matakuliah.show', $matakuliah) }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
