<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    // nama tabel otomatis mata_kuliahs dari nama model
    protected $fillable = [
        'kode',
        'nama',
        'sks',
        'semester_rekomendasi',
        'aktif',
    ];

    protected function casts(): array
    {
        return [
            'aktif' => 'boolean',
        ];
    }
}
