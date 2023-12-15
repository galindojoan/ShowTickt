<?php

namespace Database\Seeders;

// database/seeders/RecintesTableSeeder.php

use Illuminate\Database\Seeder;
use App\Models\Recinte;

class RecintesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Recinte::factory()->count(5)->create();
    }
}
