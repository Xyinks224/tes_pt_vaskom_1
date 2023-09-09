<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate([
            'name' => 'superadmin'
        ], [
            'email' => 'superadmin@gmail.com',
            'password' => 'superadmin',
            'role' => 'superadmin',
        ]);

        User::updateOrCreate([
            'name' => 'user'
        ], [
            'email' => 'user@gmail.com',
            'password' => 'user1234',
            'role' => 'user',
        ]);
    }
}
