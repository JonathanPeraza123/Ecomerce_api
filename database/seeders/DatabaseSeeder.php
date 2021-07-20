<?php

namespace Database\Seeders;

use App\Models\Variation;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Variation::factory(20)->create();
    }
}
