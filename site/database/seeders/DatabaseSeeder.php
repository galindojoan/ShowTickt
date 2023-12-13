<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if ($this->command->confirm('Vols refrescar la base de dades?', true)) {
            $this->command->call('migrate:refresh');
            $this->command->info("S'ha reconstruït la base de dades");
        }

        $eventsNum = max((int) $this->command->ask('Introdueix la quantitat de esdeveniments', 20), 1);

        \App\Models\Esdeveniment::factory($eventsNum)->create();
        $this->command->info("S'han creat $eventsNum tasques");

    }
}
