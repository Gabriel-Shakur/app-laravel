<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nnjeim\World\Actions\SeedAction;

class WorldSeeder extends Seeder
{
    public function run()
    {
        $action = new SeedAction();
        $action->setCommand($this->command); // Establece el contexto del comando
        $action->run();
    }
}

