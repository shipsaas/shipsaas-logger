# ShipSaaS - Laravel Unique Request ID Logger

[![Build & Test (PHP 8.2)](https://github.com/shipsaas/laravel-jwks/actions/workflows/build.yml/badge.svg)](https://github.com/shipsaas/laravel-jwks/actions/workflows/build.yml)
[![codecov](https://codecov.io/gh/shipsaas/laravel-jwks/graph/badge.svg?token=c0HREpn8kp)](https://codecov.io/gh/shipsaas/laravel-jwks)

TBA

## Supports
- Laravel 10+
- PHP 8.2+

## Installation

Install the library:

```bash
composer require shipsaas/laravel-unique-request-id-logger
```

## Usage

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

## Testing

Run `composer test` 😆

## Contributors
- Seth Phat

## Contributions & Support the Project

Feel free to submit any PR, please follow PSR-1/PSR-12 coding conventions and testing is a must.

If this package is helpful, please give it a ⭐️⭐️⭐️. Thank you!

## License
MIT License
