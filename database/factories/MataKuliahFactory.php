<?php

namespace Database\Factories;

use App\Models\MataKuliah;
use Illuminate\Database\Eloquent\Factories\Factory;

class MataKuliahFactory extends Factory
{
    protected $model = MataKuliah::class;

    public function definition(): array
    {
        return [
            'kode' => fake()->unique()->bothify('MK###'),
            'nama' => fake()->words(3, true),
            'sks' => fake()->numberBetween(1, 4),
            'semester_rekomendasi' => fake()->numberBetween(1, 8),
            'aktif' => true,
        ];
    }
}
