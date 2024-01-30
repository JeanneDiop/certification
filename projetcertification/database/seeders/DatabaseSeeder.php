<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //c'est permet d'execute les seeder que j'ai creer
        $this->call([
            RoleSeeder::class,
            UserSeeder::class
        ]);

    }
}
