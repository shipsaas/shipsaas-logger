<?php

namespace ShipSaasUniqueRequestLogger;

use Illuminate\Container\Container;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\HandlerInterface;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use ShipSaasUniqueRequestLogger\Processor\UniqueRequestIdProcessor;

class UniqueRequestIdLoggerInitiator
{
    public static function init(bool $useJsonFormattedLog = false): void
    {
        /** @var Logger $logger */
        $logger = Container::getInstance()->make(LoggerInterface::class);

        /** @var HandlerInterface[] $handlers */
        $handlers = $logger->getHandlers();

        $uniqueIdProcessor = Container::getInstance()->make(UniqueRequestIdProcessor::class);
        $jsonFormatter = Container::getInstance()->make(JsonFormatter::class);

        foreach ($handlers as $handler) {
            $handler->pushProcessor($uniqueIdProcessor);
            $useJsonFormattedLog && $handler->setFormatter($jsonFormatter);
        }
    }
}
