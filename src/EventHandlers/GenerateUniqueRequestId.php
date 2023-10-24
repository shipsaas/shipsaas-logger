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

        $request->merge([
            GlobalConstants::REQUEST_ID_ACCESS_KEY => $uniqueId,
        ]);
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
