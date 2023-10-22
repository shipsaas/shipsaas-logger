<?php

namespace ShipSaasUniqueRequestLogger\Processor;

use Monolog\LogRecord;
use Monolog\Processor\ProcessorInterface;

class UniqueRequestIdProcessor implements ProcessorInterface
{
    public function __invoke(LogRecord $record): LogRecord
    {
        if ($requestId = request()->input('UNIQUE_REQUEST_ID')) {
            $record['extra'] = [
                'requestId' => $requestId,
            ];
        }

        return $record;
    }
}
