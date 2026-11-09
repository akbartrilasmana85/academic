@extends('layouts.admin')

@section('judul', 'Data Mahasiswa')

@section('konten')
    <div class="header-halaman">
        <h1>Data Mahasiswa</h1>
        <a href="{{ route('admin.mahasiswa.create') }}" class="btn btn-primary">Tambah Mahasiswa</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>NIM</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Angkatan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($mahasiswas as $mahasiswa)
                <tr>
                    <td>{{ $mahasiswa->nim }}</td>
                    <td>{{ $mahasiswa->nama }}</td>
                    <td>{{ $mahasiswa->email }}</td>
                    <td>{{ $mahasiswa->angkatan }}</td>
                    <td>{{ $mahasiswa->aktif ? 'Aktif' : 'Nonaktif' }}</td>
                    <td class="aksi">
                        <a href="{{ route('admin.mahasiswa.show', $mahasiswa) }}">Lihat</a>
                        <a href="{{ route('admin.mahasiswa.edit', $mahasiswa) }}">Edit</a>
                        <form action="{{ route('admin.mahasiswa.destroy', $mahasiswa) }}" method="POST"
                              onsubmit="return confirm('Yakin hapus data {{ $mahasiswa->nama }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Belum ada data mahasiswa.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="paginasi">{{ $mahasiswas->links() }}</div>
@endsection
