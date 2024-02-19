<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nom' => 'diop',
            'prenom' =>'jeanne' ,
            'email' => 'diopj@gmail.com',
            'password' => Hash::make('azerty12'),
            'telephone' => '+221764973782',
            'etat' => 'actif',
            'adresse' => 'sicap',
            'role_id' => 1,
        ]);
    }
}
