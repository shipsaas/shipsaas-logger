<?php

namespace ShipSaasUniqueRequestLogger\Processor;

use Monolog\LogRecord;
use Monolog\Processor\ProcessorInterface;
use ShipSaasUniqueRequestLogger\Constants\GlobalConstants;

class UniqueRequestIdProcessor implements ProcessorInterface
{
    public function __invoke(LogRecord $record): LogRecord
    {
        $requestId = request()->input(GlobalConstants::REQUEST_ID_ACCESS_KEY);
        if ($requestId) {
            $record['extra'] ??= [];
            $record['extra']['requestId'] = $requestId;
        }

        return $record;
    }
}
