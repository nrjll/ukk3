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

        // $users = [
        //     [
        //         'name' => 'Nur Rijalul Annam',
        //         'email' => 'nurrijal@sija.com',
        //         'password' => bcrypt('12345678'),
        //     ],
        //     [
        //         'name' => 'Abu Bakar Tsabit Ghupron',
        //         'email' => 'abubakar@sija.com',
        //         'password' => bcrypt('12345678'),
        //     ],
        // ];

        // foreach ($users as $userData) {
        //     $user = User::create($userData);
        //     $user->assignRole('siswa');
        // }


        // $userGuru = User::create([
        //     [
        //         'name' => 'Sugiarto, ST',
        //         'email' => 'sugiarto@sija.com',
        //         'password' => bcrypt('12345678'),
        //     ],
        //     [
        //         'name' => 'Yunianto Hermawan, S.Kom',
        //         'email' => 'yunianto@sija.com',
        //         'password' => bcrypt('12345678'),
        //     ],
        // ]);

        // $userGuru->assignRole('guru');
    }
}
