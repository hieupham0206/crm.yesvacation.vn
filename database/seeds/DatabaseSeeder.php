<?php

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
        $this->call([
            ProvinceSeeder::class,

            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
        ]);

        if (App::environment() === 'local') {
            // Chạy seeder ở môi trường local
            $this->call([
//                QuickSearchSeeder::class
            ]);
        }
    }
}
