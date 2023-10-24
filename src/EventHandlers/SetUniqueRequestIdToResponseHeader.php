<?php

namespace ShipSaasUniqueRequestLogger\EventHandlers;

use Illuminate\Routing\Events\ResponsePrepared;
use ShipSaasUniqueRequestLogger\Constants\GlobalConstants;
use ShipSaasUniqueRequestLogger\Helpers\Helpers;

class SetUniqueRequestIdToResponseHeader
{
    public function handle(ResponsePrepared $responsePrepared): void
    {
        $requestId = Helpers::getUniqueRequestId();
        if (!$requestId) {
            return;
        }

        $responsePrepared->response->headers->set(
            GlobalConstants::REQUEST_ID_HEADER,
            $requestId,
            true
        );
    }
}
