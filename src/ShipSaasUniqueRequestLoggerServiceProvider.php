<?php

namespace ShipSaasUniqueRequestLogger;

use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\ServiceProvider;

class ShipSaasUniqueRequestLoggerServiceProvider extends ServiceProvider
{
    const VERSION = 'v1.0.0';

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            AboutCommand::add(
                'ShipSaaS: Laravel Unique Request Id Logger',
                fn () => ['Version' => static::VERSION]
            );
        }
    }
}
