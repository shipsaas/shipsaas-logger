<?php

namespace ShipSaasUniqueRequestLogger\Tests\Unit\Processor;

use Carbon\CarbonImmutable;
use Monolog\Level;
use Monolog\LogRecord;
use ShipSaasUniqueRequestLogger\Processor\UniqueRequestIdProcessor;
use ShipSaasUniqueRequestLogger\Tests\TestCase;

class UniqueRequestIdProcessorTest extends TestCase
{
    public function testInvokeAddsRequestIntoRecord()
    {
        $logRecord = new LogRecord(
            CarbonImmutable::now(),
            'monolog',
            Level::Info,
            'test'
        );

        request()->setRequestId('test');

        $processor = new UniqueRequestIdProcessor();
        $result = call_user_func($processor, $logRecord);

        $this->assertSame('test', $result['extra']['requestId']);
    }
}
