<?php

namespace ShipSaasUniqueRequestLogger\Tests\Unit;

use Monolog\Logger;
use Psr\Log\LoggerInterface;
use ShipSaasUniqueRequestLogger\Processor\UniqueRequestIdProcessor;
use ShipSaasUniqueRequestLogger\Tests\TestCase;
use ShipSaasUniqueRequestLogger\UniqueRequestIdLoggerInitiator;

class UniqueRequestIdLoggerInitiatorTest extends TestCase
{
    public function testInitializedOk()
    {
        UniqueRequestIdLoggerInitiator::init();

        // checks
        /** @var Logger $logger */
        $logger = $this->app->make(LoggerInterface::class);

        $handlers = collect($logger->getHandlers());

        $handlers->each(function ($handler) {
            $processor = $handler->popProcessor();

            $this->assertInstanceOf(UniqueRequestIdProcessor::class, $processor);
        });
    }
}
