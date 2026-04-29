<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Admin Piket',
            'email'    => 'admin@smkn1sby.sch.id',
            'password' => Hash::make('Buyunitacantikmybinigwe123'),
            'role'     => 'admin',
        ]);
    }
}
