@extends('layouts.admin')

@section('judul', 'Data Mata Kuliah')

@section('konten')
    <div class="header-halaman">
        <h1>Data Mata Kuliah</h1>
        <a href="{{ route('admin.matakuliah.create') }}" class="btn btn-primary">Tambah Mata Kuliah</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>SKS</th>
                <th>Semester</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($matakuliahs as $matakuliah)
                <tr>
                    <td>{{ $matakuliah->kode }}</td>
                    <td>{{ $matakuliah->nama }}</td>
                    <td>{{ $matakuliah->sks }}</td>
                    <td>{{ $matakuliah->semester_rekomendasi ?? '-' }}</td>
                    <td>{{ $matakuliah->aktif ? 'Aktif' : 'Nonaktif' }}</td>
                    <td class="aksi">
                        <a href="{{ route('admin.matakuliah.show', $matakuliah) }}">Lihat</a>
                        <a href="{{ route('admin.matakuliah.edit', $matakuliah) }}">Edit</a>
                        <form action="{{ route('admin.matakuliah.destroy', $matakuliah) }}" method="POST"
                              onsubmit="return confirm('Yakin hapus mata kuliah {{ $matakuliah->nama }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Belum ada data mata kuliah.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="paginasi">{{ $matakuliahs->links() }}</div>
@endsection
