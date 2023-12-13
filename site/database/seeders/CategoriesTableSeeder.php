<?php

namespace Database\Seeders;

// database/seeders/CategoriesTableSeeder.php

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Categoria::factory()->count(4)->create();
    }
}

