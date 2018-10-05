<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleNames = [
            [
                'name' => 'Admin'
            ],
            [
                'name' => 'CEO MANAGER DIRECTOR'
            ],
            [
                'name' => 'CFO ACCOUNTANT'
            ],
            [
                'name' => 'TELE MANAGER'
            ],
            [
                'name' => 'TELE LEADER'
            ],
            [
                'name' => 'TELE MARKETER'
            ],
            [
                'name' => 'SALE DECK MANAGER (SDM)'
            ],
            [
                'name' => 'TO'
            ],
            [
                'name' => 'REP'
            ],
            [
                'name' => 'RECEPTION'
            ],
            [
                'name' => 'CS MANAGER'
            ],
            [
                'name' => 'CS'
            ],
        ];

        \App\Models\Role::insert($roleNames);
    }
}
