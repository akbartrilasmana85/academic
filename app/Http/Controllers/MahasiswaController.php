<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MahasiswaController extends Controller
{
    public function index(): View
    {
        return view('mahasiswa.index', [
            'mahasiswas' => Mahasiswa::orderBy('nim')->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('mahasiswa.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $mahasiswa = Mahasiswa::create($this->validasi($request));

        return redirect()
            ->route('admin.mahasiswa.show', $mahasiswa)
            ->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    // route model binding: {mahasiswa} otomatis dicari berdasarkan id
    public function show(Mahasiswa $mahasiswa): View
    {
        return view('mahasiswa.show', compact('mahasiswa'));
    }

    public function edit(Mahasiswa $mahasiswa): View
    {
        return view('mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa): RedirectResponse
    {
        $mahasiswa->update($this->validasi($request, $mahasiswa));

        return redirect()
            ->route('admin.mahasiswa.show', $mahasiswa)
            ->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa): RedirectResponse
    {
        $nama = $mahasiswa->nama;
        $mahasiswa->delete();

        return redirect()
            ->route('admin.mahasiswa.index')
            ->with('success', "Data {$nama} berhasil dihapus.");
    }

    // dipakai create dan update; saat update, nim/email milik sendiri boleh tetap dipakai
    private function validasi(Request $request, ?Mahasiswa $mahasiswa = null): array
    {
        $id = $mahasiswa?->id;

        $data = $request->validate([
            'nim' => ['required', 'string', 'max:20', Rule::unique('mahasiswas', 'nim')->ignore($id)],
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', Rule::unique('mahasiswas', 'email')->ignore($id)],
            'angkatan' => ['required', 'integer', 'between:2000,2100'],
            'aktif' => ['nullable', 'boolean'],
        ]);

        // checkbox tidak terkirim saat tidak dicentang, jadi dibaca lewat boolean()
        $data['aktif'] = $request->boolean('aktif');

        return $data;
    }
}
