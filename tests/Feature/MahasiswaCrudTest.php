<?php

namespace Tests\Feature;

use App\Models\Mahasiswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MahasiswaCrudTest extends TestCase
{
    use RefreshDatabase;

    private function dataValid(array $ubah = []): array
    {
        return array_merge([
            'nim' => '2025001',
            'nama' => 'Budi Santoso',
            'email' => 'budi@example.test',
            'angkatan' => 2025,
            'aktif' => '1',
        ], $ubah);
    }

    public function test_daftar_mahasiswa_tampil_di_prefix_admin(): void
    {
        Mahasiswa::factory()->create(['nama' => 'Siti Aminah']);

        $this->get('/admin/mahasiswa')
            ->assertOk()
            ->assertSee('Siti Aminah');
    }

    public function test_form_tambah_bisa_dibuka(): void
    {
        $this->get(route('admin.mahasiswa.create'))->assertOk();
    }

    public function test_store_dengan_data_valid_menyimpan_dan_redirect(): void
    {
        $response = $this->post(route('admin.mahasiswa.store'), $this->dataValid());

        $this->assertDatabaseHas('mahasiswas', [
            'nim' => '2025001',
            'nama' => 'Budi Santoso',
            'aktif' => true,
        ]);

        $mahasiswa = Mahasiswa::where('nim', '2025001')->firstOrFail();
        $response->assertRedirect(route('admin.mahasiswa.show', $mahasiswa))
            ->assertSessionHas('success');
    }

    public function test_store_gagal_jika_nim_duplikat_atau_field_wajib_kosong(): void
    {
        Mahasiswa::factory()->create(['nim' => '2025001', 'email' => 'lain@example.test']);

        $this->post(route('admin.mahasiswa.store'), $this->dataValid())
            ->assertSessionHasErrors('nim');

        $this->post(route('admin.mahasiswa.store'), $this->dataValid(['nama' => '', 'email' => 'bukan-email']))
            ->assertSessionHasErrors(['nama', 'email']);

        $this->assertDatabaseCount('mahasiswas', 1);
    }

    public function test_show_menampilkan_detail(): void
    {
        $mahasiswa = Mahasiswa::factory()->create(['nama' => 'Rina Kartika']);

        $this->get(route('admin.mahasiswa.show', $mahasiswa))
            ->assertOk()
            ->assertSee('Rina Kartika');
    }

    public function test_form_edit_menampilkan_data_lama(): void
    {
        $mahasiswa = Mahasiswa::factory()->create(['nama' => 'Dewi Lestari']);

        $this->get(route('admin.mahasiswa.edit', $mahasiswa))
            ->assertOk()
            ->assertSee('Dewi Lestari');
    }

    public function test_update_dengan_data_valid_mengubah_data(): void
    {
        $mahasiswa = Mahasiswa::factory()->create();

        $response = $this->put(route('admin.mahasiswa.update', $mahasiswa), $this->dataValid([
            'nim' => $mahasiswa->nim,
            'email' => $mahasiswa->email,
            'nama' => 'Nama Baru',
        ]));

        $this->assertDatabaseHas('mahasiswas', ['id' => $mahasiswa->id, 'nama' => 'Nama Baru']);
        $response->assertRedirect(route('admin.mahasiswa.show', $mahasiswa))
            ->assertSessionHas('success');
    }

    public function test_update_boleh_memakai_nim_dan_email_milik_sendiri(): void
    {
        $mahasiswa = Mahasiswa::factory()->create();

        // nim dan email yang sama dengan miliknya sendiri tidak boleh dianggap duplikat
        $this->put(route('admin.mahasiswa.update', $mahasiswa), $this->dataValid([
            'nim' => $mahasiswa->nim,
            'email' => $mahasiswa->email,
        ]))->assertSessionDoesntHaveErrors();
    }

    public function test_update_gagal_jika_nim_dipakai_mahasiswa_lain(): void
    {
        Mahasiswa::factory()->create(['nim' => '2025001']);
        $mahasiswa = Mahasiswa::factory()->create(['nim' => '2025002']);

        $this->put(route('admin.mahasiswa.update', $mahasiswa), $this->dataValid(['nim' => '2025001']))
            ->assertSessionHasErrors('nim');

        $this->assertDatabaseHas('mahasiswas', ['id' => $mahasiswa->id, 'nim' => '2025002']);
    }

    public function test_destroy_menghapus_data(): void
    {
        $mahasiswa = Mahasiswa::factory()->create();

        $this->delete(route('admin.mahasiswa.destroy', $mahasiswa))
            ->assertRedirect(route('admin.mahasiswa.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('mahasiswas', ['id' => $mahasiswa->id]);
    }
}
