<?php

namespace Mdhesari\LaravelAuth\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Auth\User;
use Mdhesari\LaravelAuth\Actions\SetupToken;

class CreateNewToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sanctum:token {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $token = app(SetupToken::class)(User::whereEmail($this->argument('email'))->firstOrFail());

        $this->info($token.PHP_EOL);

        return 0;
    }
}
