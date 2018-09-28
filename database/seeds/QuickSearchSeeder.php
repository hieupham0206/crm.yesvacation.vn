<?php

use Illuminate\Database\Seeder;

class QuickSearchSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                'route'       => route('users.index'),
                'search_text' => __('User')
            ],
            [
                'route'       => route('roles.index'),
                'search_text' => __('Role')
            ],
            [
                'route'       => route('activity_logs.index'),
                'search_text' => __('Activity Log')
            ],
        ];

        \App\Models\QuickSearch::insert($datas);
    }
}
