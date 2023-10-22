# ShipSaaS - Laravel Unique Request ID Logger

[![Build & Test (PHP 8.2)](https://github.com/shipsaas/laravel-jwks/actions/workflows/build.yml/badge.svg)](https://github.com/shipsaas/laravel-jwks/actions/workflows/build.yml)
[![codecov](https://codecov.io/gh/shipsaas/laravel-jwks/graph/badge.svg?token=c0HREpn8kp)](https://codecov.io/gh/shipsaas/laravel-jwks)

Laravel UniqueRequestIdLogger enables the tracing of requests across servers
by marking each request with a unique ID 🆔.

Skyrocket the production debugging ⚒️.

Additionally, UniqueRequestIdLogger solves the **missing logs** problem when you have a huge amount of traffic 😎. 
Making production logs more reliable and engineers won't have to scream "I can't find the logs" 🔥.

## Supports
- Laravel 10+
- PHP 8.2+

## Installation

Install the library:

```bash
composer require shipsaas/laravel-unique-request-id-logger
```

## Usage (Minimalism)

Note: Minimalism way injects the UniqueRequestID into your application, it won't have any improvement for missing logs issue.

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

Additionally, you can pass the `boolean` for the first parameter to indicate if you want to have JSON-structured logs.

### Registering Middleware

```php
// Http/Kernel.php

use ShipSaasUniqueRequestLogger\GenerateUniqueRequestId;

protected $middleware = [
    // ...
    GenerateUniqueRequestId::class,  
];
```

Register the middleware in the global one, so that you won't miss any request.

### Play

Now that you have everything, hit some requests and try it out 😎.

## Usage (Advanced)

We ship a new Logger driver called `shipsaas-logger` which handles:

- Create log file based on the requestId, e.g.: `7a559daf-f1fe-4a97-8eb8-40d0907c986b.log`
- Write request-based logs there
- A fallback to the `daily` driver, if `requestId` is not presented

Thus, it fixes the missing logs issue because we have **independent log files** and not yolo-write into 1 file.

### Set up `logging.php`

TBA

### Update .env
aa

### Play
aa

## Testing

Run `composer test` 😆

## Contributors
- Seth Phat

## Contributions & Support the Project

Feel free to submit any PR, please follow PSR-1/PSR-12 coding conventions and testing is a must.

If this package is helpful, please give it a ⭐️⭐️⭐️. Thank you!

## License
MIT License
