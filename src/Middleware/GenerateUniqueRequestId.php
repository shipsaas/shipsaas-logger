<?php

namespace ShipSaasUniqueRequestLogger\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use ShipSaasUniqueRequestLogger\Constants\GlobalConstants;

class GenerateUniqueRequestId
{
    public function handle(Request $request, Closure $next)
    {
        $uniqueId = $request->header(GlobalConstants::REQUEST_ID_HEADER)
            ?: Str::orderedUuid()->toString();

        $request->merge([
            GlobalConstants::REQUEST_ID_ACCESS_KEY => $uniqueId,
        ]);

        return $next($request);
    }
}
