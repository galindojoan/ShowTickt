<?php

namespace Database\Seeders;

use App\Models\Esdeveniment;
use App\Models\Data;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class dates extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener IDs de recintos y categorias existentes
        $esdevenimentIds = Esdeveniment::pluck('id');

        data::factory()->count(10)->create([
            'esdeveniment_id' => function () use ($esdevenimentIds) {
                return rand(1, count($esdevenimentIds));
            },
        ]);
    }
}
