<?php

namespace ShipSaasUniqueRequestLogger\Tests;

use Illuminate\Foundation\Testing\WithFaker;
use Orchestra\Testbench\TestCase as BaseTestCase;
use ShipSaasUniqueRequestLogger\ShipSaasUniqueRequestLoggerServiceProvider;

abstract class TestCase extends BaseTestCase
{
    use WithFaker;

    protected function getPackageProviders($app): array
    {
        return [
            ShipSaasUniqueRequestLoggerServiceProvider::class,
        ];
    }
}
