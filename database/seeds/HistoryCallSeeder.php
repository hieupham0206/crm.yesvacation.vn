<?php

use Illuminate\Database\Seeder;

class HistoryCallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\HistoryCall::class, 20)->create();
    }
}
