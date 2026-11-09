<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MataKuliahController extends Controller
{
    public function index(): View
    {
        return view('matakuliah.index', [
            'matakuliahs' => MataKuliah::orderBy('kode')->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('matakuliah.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $matakuliah = MataKuliah::create($this->validasi($request));

        return redirect()
            ->route('admin.matakuliah.show', $matakuliah)
            ->with('success', 'Mata kuliah berhasil ditambahkan.');
    }

    // nama parameter route {matakuliah} harus sama dengan nama variabel agar route model binding jalan
    public function show(MataKuliah $matakuliah): View
    {
        return view('matakuliah.show', compact('matakuliah'));
    }

    public function edit(MataKuliah $matakuliah): View
    {
        return view('matakuliah.edit', compact('matakuliah'));
    }

    public function update(Request $request, MataKuliah $matakuliah): RedirectResponse
    {
        $matakuliah->update($this->validasi($request, $matakuliah));

        return redirect()
            ->route('admin.matakuliah.show', $matakuliah)
            ->with('success', 'Mata kuliah berhasil diperbarui.');
    }

    public function destroy(MataKuliah $matakuliah): RedirectResponse
    {
        $nama = $matakuliah->nama;
        $matakuliah->delete();

        return redirect()
            ->route('admin.matakuliah.index')
            ->with('success', "Mata kuliah {$nama} berhasil dihapus.");
    }

    private function validasi(Request $request, ?MataKuliah $matakuliah = null): array
    {
        $id = $matakuliah?->id;

        $data = $request->validate([
            'kode' => ['required', 'string', 'max:20', Rule::unique('mata_kuliahs', 'kode')->ignore($id)],
            'nama' => ['required', 'string', 'max:120'],
            'sks' => ['required', 'integer', 'between:1,6'],
            'semester_rekomendasi' => ['nullable', 'integer', 'between:1,8'],
            'aktif' => ['nullable', 'boolean'],
        ]);

        $data['aktif'] = $request->boolean('aktif');

        return $data;
    }
}
