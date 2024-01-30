<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles=[
            [
                'nom'=>'proprietaire'
            ],
            [
                'nom'=>'employe'
            ],
        ];

        foreach($roles as $key => $role){
            Role::create($role);
        }
    }
}
