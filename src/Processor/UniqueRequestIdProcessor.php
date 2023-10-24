<?php

namespace ShipSaasUniqueRequestLogger\Processor;

use Monolog\LogRecord;
use Monolog\Processor\ProcessorInterface;
use ShipSaasUniqueRequestLogger\Constants\GlobalConstants;
use ShipSaasUniqueRequestLogger\Helpers\Helpers;

class UniqueRequestIdProcessor implements ProcessorInterface
{
    public function __invoke(LogRecord $record): LogRecord
    {
        $requestId = Helpers::getUniqueRequestId();
        if ($requestId) {
            $record['extra'] ??= [];
            $record['extra']['requestId'] = $requestId;
        }

        return $record;
    }
}
