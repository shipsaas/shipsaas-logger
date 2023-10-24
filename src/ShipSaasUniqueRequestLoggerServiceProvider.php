<?php

namespace ShipSaasUniqueRequestLogger;

use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Log\LogManager;
use Illuminate\Support\ServiceProvider;
use Monolog\Logger as Monolog;
use ShipSaasUniqueRequestLogger\Processor\UniqueRequestIdProcessor;

class ShipSaasUniqueRequestLoggerServiceProvider extends ServiceProvider
{
    const VERSION = 'v1.0.0';

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            AboutCommand::add(
                'ShipSaaS: Logger',
                fn () => ['Version' => static::VERSION]
            );
        }

        $this->app->afterResolving(LogManager::class, function (LogManager $manager) {
            $manager->extend('shipsaas-logger', function (array $config) {
                /** @var LogManager $this */

                $handler = $this->channel('stack');

                return new Monolog(
                    'shipsaas-logger',
                    [
                        ...$handler->getHandlers(),
                    ],
                    [
                        ...$handler->getProcessors(),
                        $this->app->make(UniqueRequestIdProcessor::class)
                    ]
                );
            });
        });
    }
}
