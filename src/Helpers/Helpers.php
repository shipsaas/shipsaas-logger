<?php

namespace ShipSaasUniqueRequestLogger\Helpers;

use Illuminate\Container\Container;

final class Helpers
{
    public static function getUniqueRequestId(): ?string
    {
        // we need to access the Request via Container
        // thus make it compatible with Laravel Octane
        return Container::getInstance()
            ->make('request')
            ->getRequestId();
    }
}
