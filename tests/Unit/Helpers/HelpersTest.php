<?php

namespace ShipSaasUniqueRequestLogger\Tests\Unit\Helpers;

use ShipSaasUniqueRequestLogger\Helpers\Helpers;
use ShipSaasUniqueRequestLogger\Tests\TestCase;

class HelpersTest extends TestCase
{
    public function testGetRequestIdReturnsRequestId()
    {
        request()->setRequestId('hehe');

        $rqId = Helpers::getUniqueRequestId();

        $this->assertSame('hehe', $rqId);
    }

    public function testGetRequestIdReturnsNull()
    {
        $rqId = Helpers::getUniqueRequestId();

        $this->assertNull($rqId);
    }
}
