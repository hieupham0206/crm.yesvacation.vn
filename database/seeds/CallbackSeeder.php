<?php

use Illuminate\Database\Seeder;

class CallbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Callback::class, 20)->create();
    }
}
