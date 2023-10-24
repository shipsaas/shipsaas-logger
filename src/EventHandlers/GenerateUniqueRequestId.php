<?php

namespace ShipSaasUniqueRequestLogger\EventHandlers;

use Illuminate\Routing\Events\Routing;
use Illuminate\Support\Str;
use ShipSaasUniqueRequestLogger\Constants\GlobalConstants;

class GenerateUniqueRequestId
{
    public function handle(Routing $routingEvent): void
    {
        $request = $routingEvent->request;

        $uniqueId = $request->header(GlobalConstants::REQUEST_ID_HEADER)
            ?: $this->generateId();

        // we have a marco function bound to the Request facade
        $request->setRequestId($uniqueId);
    }

    private function generateId(): string
    {
        $idMode = config('logging.channels.shipsaas-logger.id-type', 'uuid');

        return match ($idMode) {
            'uuid' => Str::uuid(),
            'orderedUuid' => Str::orderedUuid(),
            'ulid' => Str::ulid(),
        };
    }
}
