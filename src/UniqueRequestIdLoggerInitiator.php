<?php

namespace ShipSaasUniqueRequestLogger;

use Illuminate\Container\Container;
use Monolog\Handler\HandlerInterface;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use ShipSaasUniqueRequestLogger\Processor\UniqueRequestIdProcessor;

final class UniqueRequestIdLoggerInitiator
{
    public static function init(): void
    {
        /** @var Logger $logger */
        $logger = Container::getInstance()->make(LoggerInterface::class);

        /** @var HandlerInterface[] $handlers */
        $handlers = $logger->getHandlers();

        $uniqueIdProcessor = Container::getInstance()->make(UniqueRequestIdProcessor::class);

        foreach ($handlers as $handler) {
            $handler->pushProcessor($uniqueIdProcessor);
        }
    }
}
