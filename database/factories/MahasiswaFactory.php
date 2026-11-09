<?php

namespace Database\Factories;

use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

class MahasiswaFactory extends Factory
{
    protected $model = Mahasiswa::class;

    public function definition(): array
    {
        return [
            'nim' => fake()->unique()->numerify('2025#####'),
            'nama' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'angkatan' => fake()->numberBetween(2020, 2026),
            'aktif' => true,
        ];
    }

    public function nonaktif(): static
    {
        return $this->state(fn () => ['aktif' => false]);
    }
}
