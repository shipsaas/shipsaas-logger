<?php

namespace ShipSaasUniqueRequestLogger\Tests\Unit\EventHandlers;

use Illuminate\Http\Request;
use Illuminate\Routing\Events\Routing;
use Illuminate\Support\Str;
use ShipSaasUniqueRequestLogger\Constants\GlobalConstants;
use ShipSaasUniqueRequestLogger\EventHandlers\GenerateUniqueRequestId;
use ShipSaasUniqueRequestLogger\Tests\TestCase;

class GenerateUniqueRequestIdTest extends TestCase
{
    public function testHandlerGeneratesAndSetsTheUniqueRequestIdUsingUuid()
    {
        $request = $this->app->make(Request::class);

        config([
            'logging.channels.shipsaas-logger.id-type' => 'uuid',
        ]);

        $event = new Routing($request);

        $handler = new GenerateUniqueRequestId();
        $handler->handle($event);

        $this->assertNotNull($request->getRequestId());
        $this->assertTrue(Str::isUuid($request->getRequestId()));
    }

    public function testHandlerGeneratesAndSetsTheUniqueRequestIdUsingOrderedUuid()
    {
        $request = $this->app->make(Request::class);

        config([
            'logging.channels.shipsaas-logger.id-type' => 'orderedUuid',
        ]);

        $event = new Routing($request);

        $handler = new GenerateUniqueRequestId();
        $handler->handle($event);

        $this->assertNotNull($request->getRequestId());
        $this->assertTrue(Str::isUuid($request->getRequestId()));
    }

    public function testHandlerGeneratesAndSetsTheUniqueRequestIdUsingUlid()
    {
        $request = $this->app->make(Request::class);

        config([
            'logging.channels.shipsaas-logger.id-type' => 'ulid',
        ]);

        $event = new Routing($request);

        $handler = new GenerateUniqueRequestId();
        $handler->handle($event);

        $this->assertNotNull($request->getRequestId());
        $this->assertTrue(Str::isUlid($request->getRequestId()));
    }

    public function testHandlerSetsTheUniqueRequestIdFromHeader()
    {
        $request = $this->app->make(Request::class);
        $request->headers->set(GlobalConstants::REQUEST_ID_HEADER, 'test');

        $event = new Routing($request);

        $handler = new GenerateUniqueRequestId();
        $handler->handle($event);

        $this->assertSame('test', $request->getRequestId());
    }
}
