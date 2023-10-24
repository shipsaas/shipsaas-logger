<?php

namespace ShipSaasUniqueRequestLogger\EventHandlers;

use Illuminate\Container\Container;
use Illuminate\Routing\Events\ResponsePrepared;
use ShipSaasUniqueRequestLogger\Constants\GlobalConstants;

class SetUniqueRequestIdToResponseHeader
{
    public function handle(ResponsePrepared $responsePrepared): void
    {
        $requestId = Container::getInstance()
            ->make('request')
            ->input(GlobalConstants::REQUEST_ID_HEADER);
        if (!$requestId) {
            return;
        }

        $responsePrepared->response->headers->set(
            GlobalConstants::REQUEST_ID_HEADER,
            $requestId
        );
    }
}
