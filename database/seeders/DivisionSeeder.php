<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisions = [
            [
                'name' => 'Divisi Budaya',
                'code' => 'BUDAYA',
                'description' => 'Menangani segala kegiatan yang berhubungan dengan pelestarian budaya Sunda',
                'is_active' => true,
            ],
            [
                'name' => 'Divisi Kegiatan',
                'code' => 'KEGIATAN',
                'description' => 'Menangani perencanaan dan pelaksanaan kegiatan organisasi',
                'is_active' => true,
            ],
            [
                'name' => 'Divisi Musik',
                'code' => 'MUSIK',
                'description' => 'Menangani segala kegiatan yang berhubungan dengan musik tradisional Sunda',
                'is_active' => true,
            ],
        ];
        
        foreach ($divisions as $division) {
            Division::create($division);
        }
    }
}
