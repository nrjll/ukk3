<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'AdminTes',
            'email' => 'admintes@sija.com',
            'password' => bcrypt('12345678'),
        ]);

        $user->assignRole('super_admin');
    }
}
