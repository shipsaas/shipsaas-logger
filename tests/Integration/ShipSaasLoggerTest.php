<?php

namespace ShipSaasUniqueRequestLogger\Tests\Integration;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use ShipSaasUniqueRequestLogger\Constants\GlobalConstants;
use ShipSaasUniqueRequestLogger\Tests\TestCase;

class ShipSaasLoggerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createFakeApp();
    }

    public function testWriteLogShouldContainsRequestIdNormalView()
    {
        $res = $this->json('GET', 'write-logs')
            ->assertOk()
            ->assertSee('ok')
            ->assertHeader(GlobalConstants::REQUEST_ID_HEADER);

        $headerValue = $res->headers->get(GlobalConstants::REQUEST_ID_HEADER);

        // header is valid
        $this->assertNotNull($headerValue);
        $this->assertTrue(Str::isUlid($headerValue));

        // log file assertions
        $filePath = __DIR__ . "/logs/$headerValue.log";
        $this->assertFileExists($filePath);

        // read the logs
        $logs = file_get_contents($filePath);
        $lines = explode("\n", $logs);

        // we write 2 lines, but the last \n count too => 3
        $this->assertCount(3, $lines);

        $this->assertStringContainsString('{"requestId":"'.$headerValue.'"}', $lines[0]);
        $this->assertStringContainsString('{"requestId":"'.$headerValue.'"}', $lines[1]);
    }

    public function testWriteLogShouldContainsRequestIdJsonView()
    {
        config([
            'logging.channels.shipsaas-logger.use_json_format' => true,
        ]);

        $res = $this->json('GET', 'write-logs')
            ->assertOk()
            ->assertSee('ok')
            ->assertHeader(GlobalConstants::REQUEST_ID_HEADER);

        $headerValue = $res->headers->get(GlobalConstants::REQUEST_ID_HEADER);

        // header is valid
        $this->assertNotNull($headerValue);
        $this->assertTrue(Str::isUlid($headerValue));

        // log file assertions
        $filePath = __DIR__ . "/logs/$headerValue.log";
        $this->assertFileExists($filePath);

        // read the logs
        $logs = file_get_contents($filePath);
        $lines = explode("\n", $logs);

        // we write 2 lines, but the last \n count too => 3
        $this->assertCount(3, $lines);

        $this->assertJson($lines[0]);
        $this->assertJson($lines[1]);

        $line0Json = json_decode($lines[0], true);
        $line1Json = json_decode($lines[1], true);

        $this->assertSame($headerValue, $line0Json['extra']['requestId']);
        $this->assertSame($headerValue, $line1Json['extra']['requestId']);
    }

    private function createFakeApp(): void
    {
        config([
            'logging.default' => 'shipsaas-logger',
            'logging.channels.shipsaas-logger' => [
                'driver' => 'shipsaas-logger',
                'path' => __DIR__ . '/logs/hehe.log',
                'default_log_file' => __DIR__ . '/logs/hehe.log',
                'id-type' => 'ulid',
                'use_json_format' => false,
            ],
        ]);

        Route::get('write-logs', function () {
            Log::info('Test info log', [
                'id' => 'this-is-id',
            ]);

            Log::warning('Test warning pro', [
                'id' => 'this-is-id-warning',
            ]);

            return 'ok';
        });
    }
}
