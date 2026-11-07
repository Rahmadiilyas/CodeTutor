<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InstrukturSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'instruktur1@malaqbi.test',
            ],
            [
                'nama' => 'Budi Santoso',
                'kata_sandi' => Hash::make('instruktur123'),
                'peran' => 'instruktur',
                'status' => true,
                'foto' => null,
            ]
        );

        User::updateOrCreate(
            [
                'email' => 'instruktur2@malaqbi.test',
            ],
            [
                'nama' => 'Siti Rahma',
                'kata_sandi' => Hash::make('instruktur123'),
                'peran' => 'instruktur',
                'status' => true,
                'foto' => null,
            ]
        );

        User::updateOrCreate(
            [
                'email' => 'instruktur3@malaqbi.test',
            ],
            [
                'nama' => 'Andi Kurniawan',
                'kata_sandi' => Hash::make('instruktur123'),
                'peran' => 'instruktur',
                'status' => false,
                'foto' => null,
            ]
        );
    }
}