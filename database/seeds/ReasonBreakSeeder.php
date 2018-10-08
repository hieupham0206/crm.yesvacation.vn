<?php

use Illuminate\Database\Seeder;

class ReasonBreakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                'name' => 'Goto Toilet 1',
                'time_alert' => 5
            ],
            [
                'name' => 'Goto Toilet 2',
                'time_alert' => 15
            ],
            [
                'name' => 'Break',
                'time_alert' => 5
            ],
            [
                'name' => 'Lunch',
                'time_alert' => 5
            ],
            [
                'name' => 'Another Reason',
                'time_alert' => 5
            ],
        ];

        \App\Models\ReasonBreak::insert($datas);
    }
}
