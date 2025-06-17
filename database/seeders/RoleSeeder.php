<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Crea el rol ADMINISTRADOR si no existe
        Role::firstOrCreate(['name' => 'ADMINISTRADOR']);
    }
}
