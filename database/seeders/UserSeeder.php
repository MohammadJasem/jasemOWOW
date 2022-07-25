<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'              =>  'Boss1',
            'email'             =>  'boss1@admin.com',
            'role'              =>  'boss',
            'email_verified_at' =>  now(),
            'password'          =>  'admin_password',
            'remember_token'    =>  Str::random(10),
            'created_at'        =>  now(),
            'updated_at'        =>  now(),
        ]);
        User::create([
            'name'              =>  'Boss2',
            'email'             =>  'boss2@admin.com',
            'role'              =>  'boss',
            'email_verified_at' =>  now(),
            'password'          =>  'admin_password',
            'remember_token'    =>  Str::random(10),
            'created_at'        =>  now(),
            'updated_at'        =>  now(),
        ]);

        User::factory()
            ->count(1000)
            ->create();
    }
}
