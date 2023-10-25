<?php

namespace ShipSaasUniqueRequestLogger\Handlers;

use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\LogRecord;
use Monolog\Utils;
use ShipSaasUniqueRequestLogger\Helpers\Helpers;

class UniqueRequestIdFileHandler extends StreamHandler
{
    protected string $defaultLogFile;

    public function __construct(
        string $filename,
        ?string $defaultFilename = null,
        bool $useJsonFormat = false,
        int|string|Level $level = Level::Debug,
        bool $bubble = true,
        ?int $filePermission = null,
        bool $useLocking = false
    ) {
        $this->filename = Utils::canonicalizePath($filename);
        $this->defaultLogFile = $defaultFilename ?? $filename;

        $useJsonFormat && $this->setFormatter(new JsonFormatter());

        parent::__construct($filename, $level, $bubble, $filePermission, $useLocking);
    }

    protected function getFullFilePath(string $requestId): string
    {
        $fileInfo = pathinfo($this->filename);
        $fileName = $requestId . '.' . ($fileInfo['extension'] ?? '.log');

        return sprintf(
            '%s/%s',
            $fileInfo['dirname'] ?? '',
            $fileName
        );
    }

    protected function write(LogRecord $record): void
    {
        $requestId = Helpers::getUniqueRequestId();
        if (!empty($requestId)) {
            $this->url = $this->getFullFilePath($requestId);
        }

        parent::write($record);
    }
}
