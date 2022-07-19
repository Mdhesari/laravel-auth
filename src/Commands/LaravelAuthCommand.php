<?php

namespace LaravelAuth\LaravelAuth\Commands;

use Illuminate\Console\Command;

class LaravelAuthCommand extends Command
{
    public $signature = 'laravel-auth';

    public $description = 'Setup Laravel Auth';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
