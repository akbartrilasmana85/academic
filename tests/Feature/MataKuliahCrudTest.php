<?php

namespace Tests\Feature;

use App\Models\MataKuliah;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MataKuliahCrudTest extends TestCase
{
    use RefreshDatabase;

    private function dataValid(array $ubah = []): array
    {
        return array_merge([
            'kode' => 'TI101',
            'nama' => 'Pemrograman Web Lanjutan',
            'sks' => 3,
            'semester_rekomendasi' => 5,
            'aktif' => '1',
        ], $ubah);
    }

    public function test_daftar_mata_kuliah_tampil_di_prefix_admin(): void
    {
        MataKuliah::factory()->create(['nama' => 'Basis Data Lanjut']);

        $this->get('/admin/matakuliah')
            ->assertOk()
            ->assertSee('Basis Data Lanjut');
    }

    public function test_form_tambah_bisa_dibuka(): void
    {
        $this->get(route('admin.matakuliah.create'))->assertOk();
    }

    public function test_store_dengan_data_valid_menyimpan_dan_redirect(): void
    {
        $response = $this->post(route('admin.matakuliah.store'), $this->dataValid());

        $this->assertDatabaseHas('mata_kuliahs', [
            'kode' => 'TI101',
            'sks' => 3,
            'aktif' => true,
        ]);

        $matakuliah = MataKuliah::where('kode', 'TI101')->firstOrFail();
        $response->assertRedirect(route('admin.matakuliah.show', $matakuliah))
            ->assertSessionHas('success');
    }

    public function test_store_gagal_jika_kode_duplikat_atau_sks_di_luar_batas(): void
    {
        MataKuliah::factory()->create(['kode' => 'TI101']);

        $this->post(route('admin.matakuliah.store'), $this->dataValid())
            ->assertSessionHasErrors('kode');

        $this->post(route('admin.matakuliah.store'), $this->dataValid(['kode' => 'TI999', 'sks' => 9]))
            ->assertSessionHasErrors('sks');

        $this->assertDatabaseCount('mata_kuliahs', 1);
    }

    public function test_show_menampilkan_detail(): void
    {
        $matakuliah = MataKuliah::factory()->create(['nama' => 'Jaringan Komputer']);

        $this->get(route('admin.matakuliah.show', $matakuliah))
            ->assertOk()
            ->assertSee('Jaringan Komputer');
    }

    public function test_form_edit_menampilkan_data_lama(): void
    {
        $matakuliah = MataKuliah::factory()->create(['nama' => 'Algoritma Lanjut']);

        $this->get(route('admin.matakuliah.edit', $matakuliah))
            ->assertOk()
            ->assertSee('Algoritma Lanjut');
    }

    public function test_update_dengan_data_valid_mengubah_data(): void
    {
        $matakuliah = MataKuliah::factory()->create();

        $response = $this->put(route('admin.matakuliah.update', $matakuliah), $this->dataValid([
            'kode' => $matakuliah->kode,
            'nama' => 'Nama Baru MK',
        ]));

        $this->assertDatabaseHas('mata_kuliahs', ['id' => $matakuliah->id, 'nama' => 'Nama Baru MK']);
        $response->assertRedirect(route('admin.matakuliah.show', $matakuliah))
            ->assertSessionHas('success');
    }

    public function test_update_boleh_memakai_kode_milik_sendiri(): void
    {
        $matakuliah = MataKuliah::factory()->create();

        $this->put(route('admin.matakuliah.update', $matakuliah), $this->dataValid([
            'kode' => $matakuliah->kode,
        ]))->assertSessionDoesntHaveErrors();
    }

    public function test_update_gagal_jika_kode_dipakai_mata_kuliah_lain(): void
    {
        MataKuliah::factory()->create(['kode' => 'TI101']);
        $matakuliah = MataKuliah::factory()->create(['kode' => 'TI202']);

        $this->put(route('admin.matakuliah.update', $matakuliah), $this->dataValid(['kode' => 'TI101']))
            ->assertSessionHasErrors('kode');

        $this->assertDatabaseHas('mata_kuliahs', ['id' => $matakuliah->id, 'kode' => 'TI202']);
    }

    public function test_destroy_menghapus_data(): void
    {
        $matakuliah = MataKuliah::factory()->create();

        $this->delete(route('admin.matakuliah.destroy', $matakuliah))
            ->assertRedirect(route('admin.matakuliah.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('mata_kuliahs', ['id' => $matakuliah->id]);
    }
}
