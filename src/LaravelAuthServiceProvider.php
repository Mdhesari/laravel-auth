<?php

namespace Mdhesari\LaravelAuth;

use Mdhesari\LaravelAuth\Commands\CreateNewToken;
use Mdhesari\LaravelAuth\Commands\LaravelAuthCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelAuthServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-auth')
            ->hasConfigFile('laravel-auth')
            ->hasRoute('api')
            ->hasMigration('create_users_table')
            ->runsMigrations(true)
            ->hasCommands([
                LaravelAuthCommand::class,
                CreateNewToken::class,
            ]);
    }
}
