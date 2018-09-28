<?php

class UserSeeder extends \Illuminate\Database\Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::create([
            'username'       => 'admin',
            'email'          => 'hieu.pham@cloudteam.vn',
            'password'       => \Hash::make(123456),
            'remember_token' => str_random(10),
            'use_otp'        => 0
        ]);

        if ($user) {
            $user->assignRole('Admin');
        }

        factory(\App\Models\User::class, 15)->create();
    }
}