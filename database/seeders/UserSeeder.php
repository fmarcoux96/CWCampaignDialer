<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'email' => 'fmarcoux@conceptsweb.ca',
        ], [
            'name' => 'Frederick Marcoux',
            'password' => \Hash::make('demo1234'),
            'email' => 'fmarcoux@conceptsweb.ca',
            'email_verified_at' => now(),
            'role' => 'superadmin',
        ]);
    }
}
