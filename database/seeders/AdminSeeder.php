<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            'name' => 'Super Admin',
            'email' => 'superAdmin@mail.com',
            'password' => Hash::make('superAdmin@123'),
            'role_id' => '1', // يمكنك تغيير هذا إلى ID دور معين إذا كنت ترغب في ذلك
            'status' => 'active'
        ]);
        DB::table('admins')->insert([
            'name' => 'Admin',
            'email' => 'Admin@mail.com',
            'password' => Hash::make('Admin@123'),
            'role_id' => '2', // يمكنك تغيير هذا إلى ID دور معين إذا كنت ترغب في ذلك
             'status' => 'active'
        ]);
        DB::table('admins')->insert([
            'name' => 'Writer',
            'email' => 'Writer@mail.com',
            'password' => Hash::make('Writer@123'),
            'role_id' => '3', // يمكنك تغيير هذا إلى ID دور معين إذا كنت ترغب في ذلك
             'status' => 'active'
        ]);
        DB::table('admins')->insert([
            'name' => 'Reviewer',
            'email' => 'Reviewer@mail.com',
            'password' => Hash::make('Reviewer@123'),
            'role_id' => '4', // يمكنك تغيير هذا إلى ID دور معين إذا كنت ترغب في ذلك
             'status' => 'active'
        ]);

    }
}
