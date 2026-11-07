<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@malaqbi.test',
            ],
            [
                'nama' => 'Administrator',
                'kata_sandi' => Hash::make('admin12345'),
                'peran' => 'admin',
                'status' => true,
                'foto' => null,
            ]
        );
    }
}