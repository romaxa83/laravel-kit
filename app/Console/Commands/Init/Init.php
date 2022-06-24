<?php

namespace App\Console\Commands\Init;

use Illuminate\Console\Command;

class Init extends Command
{
    protected $signature = 'app:init';

    protected $description = 'Init data for app';

    public function handle()
    {
        $this->call('app:create-admin');
    }
}

