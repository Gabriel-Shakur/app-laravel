<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permision\Models\Permission;
use Spatie\Permision\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $administrador = Role::create(['name=>ADMINISTRADOR']);


    }
}
