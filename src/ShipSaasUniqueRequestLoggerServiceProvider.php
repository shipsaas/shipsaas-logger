<?php

namespace ShipSaasUniqueRequestLogger;

use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Log\LogManager;
use Illuminate\Routing\Events\ResponsePrepared;
use Illuminate\Routing\Events\Routing;
use Illuminate\Support\ServiceProvider;
use Monolog\Logger as Monolog;
use ShipSaasUniqueRequestLogger\EventHandlers\SetUniqueRequestIdToResponseHeader;
use ShipSaasUniqueRequestLogger\Handlers\UniqueRequestIdFileHandler;
use ShipSaasUniqueRequestLogger\EventHandlers\GenerateUniqueRequestId;
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

        $this->app['events']->listen(Routing::class, GenerateUniqueRequestId::class);
        $this->app['events']->listen(ResponsePrepared::class, SetUniqueRequestIdToResponseHeader::class);
    }

    public function register(): void
    {
        $this->app->afterResolving(LogManager::class, function (LogManager $manager) {
            $manager->extend('shipsaas-logger', function ($laravel, array $config) {
                /** @var LogManager $this */
                $baseLogger = $this->channel('stack');

                $uniqueIdHandler = new UniqueRequestIdFileHandler(
                    $config['path'],
                    $config['default_log_file'],
                    $config['use_json_format'] ?? false
                );

                $logProcessors = [
                    ...$baseLogger->getProcessors(),
                    $this->app->make(UniqueRequestIdProcessor::class)
                ];

                return new Monolog(
                    'shipsaas-logger',
                    [$uniqueIdHandler],
                    $logProcessors
                );
            });
        });
    }
}
