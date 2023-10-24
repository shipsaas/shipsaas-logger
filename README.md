# ShipSaaS - Laravel Unique Request ID Logger - ShipSaaS Logger

[![Build & Test (PHP 8.2)](https://github.com/shipsaas/laravel-jwks/actions/workflows/build.yml/badge.svg)](https://github.com/shipsaas/laravel-jwks/actions/workflows/build.yml)
[![codecov](https://codecov.io/gh/shipsaas/laravel-jwks/graph/badge.svg?token=c0HREpn8kp)](https://codecov.io/gh/shipsaas/laravel-jwks)

Laravel ShipSaasLogger enables the tracing of requests across servers
by marking each request with a unique ID 🆔 for every log record of the given request.

Skyrocket your production debugging ⚒️.

Additionally, ShipSaasLogger solves the **missing logs** problem when you have a huge amount of traffic 😎. 
Making production logs more reliable and engineers won't have to scream "I can't find the logs" 🔥.

## Supports
- Laravel 10+
- PHP 8.2+

## Installation

Install the library:

```bash
composer require shipsaas/shipsaas-logger
```

## Usage (Minimalism)

### Inject Unique Request Id Logger Processor

By simply putting this piece of code into your `AppServiceProvider`:

```php
// AppServiceProvider.php

use ShipSaasUniqueRequestLogger\UniqueRequestIdLoggerInitiator;

public function boot(): void
{
    $this->app->booted(fn () => UniqueRequestIdLoggerInitiator::init());
}
```

### Play

Now that you have everything, hit some requests and try it out 😎.

Note: Minimalism way injects the UniqueRequestID generation into your application, it won't have any improvement for missing logs issue.

## Usage (Advanced)

We ship a new Logger driver called `shipsaas-logger` which handles:

- Create log file based on the requestId, e.g.: `7a559daf-f1fe-4a97-8eb8-40d0907c986b.log`
- Write request-based logs there
- A fallback to the default log file, if `requestId` is not presented

Thus, it fixes the missing logs issue because we have **independent log files** and not yolo-write into 1 file.

And last step, tell Sumologic, Cloudwatch, ... sync your logs folder 🔥. All your logs will be on the cloud.

### Set up `config/logging.php`

Add a new channel called `shipsaas-logger`

```php
'shipsaas-logger' => [
    'driver' => 'shipsaas-logger',
    'path' => storage_path('logs/requests/laravel.log'), // can change to your desired path
    'default_log_file' => storage_path('logs/laravel.log'), // can change to your desired path
    'id-type' => 'ulid', // uuid, orderedUuid, ulid
    'use_json_format' => false, // set to true to write log as JSON
],
```

### Update .env

Change the `LOG_CHANNEL` to `shipsaas-logger` 

```dotenv
LOG_CHANNEL=shipsaas-logger
```

### Play
Now that you have everything, hit some requests and try it out 😎.

And congrats, no more "missing logs" pain for your app 😉.

## Testing

Run `composer test` 😆

## Contributors
- Seth Phat

## Contributions & Support the Project

Feel free to submit any PR, please follow PSR-1/PSR-12 coding conventions and testing is a must.

If this package is helpful, please give it a ⭐️⭐️⭐️. Thank you!

## License
MIT License
