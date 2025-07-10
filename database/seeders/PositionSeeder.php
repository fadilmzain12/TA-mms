<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            [
                'name' => 'Kepala Divisi',
                'code' => 'KADIV',
                'description' => 'Memimpin dan mengkoordinasi seluruh kegiatan divisi',
                'is_active' => true,
            ],
            [
                'name' => 'Bendahara',
                'code' => 'BENDAHARA',
                'description' => 'Mengelola keuangan divisi atau organisasi',
                'is_active' => true,
            ],
            [
                'name' => 'Asisten',
                'code' => 'ASISTEN',
                'description' => 'Membantu kepala divisi dalam pelaksanaan program kerja',
                'is_active' => true,
            ],
            [
                'name' => 'Anggota',
                'code' => 'ANGGOTA',
                'description' => 'Anggota reguler dari divisi',
                'is_active' => true,
            ],
        ];
        
        foreach ($positions as $position) {
            Position::create($position);
        }
    }
}
