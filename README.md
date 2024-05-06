# Kocuj DI
Container for design pattern Dependency Injection in PHP 7

[![Author](http://img.shields.io/badge/author-kocuj.pl-blue.svg?style=flat-square)](http://kocuj.pl)
[![Latest Version](https://img.shields.io/github/release/kocuj/di.svg?style=flat-square)](https://github.com/kocuj/di/releases)
[![Github Issues](http://githubbadges.herokuapp.com/kocuj/di/issues.svg)](https://github.com/kocuj/di/issues)
[![Pending Pull-Requests](http://githubbadges.herokuapp.com/kocuj/di/pulls.svg)](https://github.com/kocuj/di/pulls)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://github.com/kocuj/di/blob/master/LICENSE.md)
[![Build Status](https://img.shields.io/travis/kocuj/di/master.svg?style=flat-square)](https://travis-ci.org/kocuj/di)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/kocuj/di.svg?style=flat-square)](https://scrutinizer-ci.com/g/kocuj/di/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/kocuj/di.svg?style=flat-square)](https://scrutinizer-ci.com/g/kocuj/di)
[![Total Downloads](https://img.shields.io/packagist/dt/kocuj/di.svg?style=flat-square)](https://packagist.org/packages/kocuj/di)

This package is compliant with [PSR-1](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md), [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md), [PSR-11](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-11-container.md) and [PSR-12](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-12-extended-coding-style-guide.md). If you notice compliance oversights, please send a patch via pull request.

## [Download 2.0.0](https://github.com/kocuj/di/releases/tag/v2.0.0)

DO NOT USE THIS BRANCH ON PRODUCTION! THIS BRANCH IS ONLY FOR DEVELOPMENT OF VERSION 2.0.

## Install

Via Composer:

``` bash
$ composer require kocuj/di
```

## Requirements

The following versions of PHP are supported by this version:

* PHP 7.4
* PHP 8.0
* PHP 8.1
* PHP 8.2
* PHP 8.3

## Documentation

In this documentation it is assumed that you will import namespaces for the Kocuj DI library by using the following code:

```php
use Kocuj\Di\Di;
```

To use the Kocuj DI library you must first initialize it:

```php
$di = new Di();
```

It will create a Kocuj DI library object. You can create more Di objects, but it is not recommended. The better solution is to create more DI containers, which will be explained in the next part of this documentation.

After the construction, the $di variable will have one container for Dependency Injection, which you can get by using the following code:

```php
$defaultContainer = $di->getDefault();
```

You can also create more containers:

```php
$myContainer = $di->create();
```

You can also create new container based on already existing container by using the following code:

```php
$myContainer = $di->copy($oldContainer);
```

From now on you can use new container by using methods on $myContainer variable. However, the following documentation will use default container for explanations about using the Kocuj DI library.

After creating the container (default or other), you can add services into it. There are two types of services:

* shared - service which will be constructed only once, like in Singleton design pattern;
* standard - service which will be constructed on each use.

To create service you can use the following method:
`add(ServiceType $serviceType, string $id, $serviceSource): ContainerInterface`

The $serviceType argument can be one of the following:

* to create shared service - `new ServiceType(ServiceType::SHARED)`;
* to create standard service - `new ServiceType(ServiceType::STANDARD)`.

If you want to ommit a $serviceType argument, you can use one of the following methods:

* to create shared service - `addShared(string $id, $serviceSource): ContainerInterface`;
* to create standard service - `addStandard(string $id, $serviceSource): ContainerInterface`.

Argument $id is an identifier of created service. All identifiers will be automatically converted to camelCase format. Remember, that inside one container there can be only one service with the selected identifier.

Argument $serviceSource is a service to use with the selected identifier. It can be one of the following types:

* an object - this object will be used as service;
* an anonymous function - this function has no arguments and should return an object which will be used as service;
* a class- it should be an array with the following elements:
  * `className` - required element; it is fully qualified class name for service (it is a good practice to use "::class" notation in this place);
  * `arguments` - optional element; more information about this element are below in this documentation.

The best feature of the Kocuj DI library is to automatically resolving dependencies between services when a $serviceSource argument is an array. To use this feature, there should be at least one argument sent to a service constructor. The place to do so is in element "arguments" inside an array for argument $serviceSource.

Each argument in $arguments contains an array with one element with index "type" and second with index "value" which value depends on value set in index "type". Element with index "type" contains a name of argument type.

There are two types of arguments selected by element with index "type":

* "service" - to set service to get, there must be a second element in array with index "value" containing service identifier;
* "value" - to set value, there must be a second element in array with index "value" containing this value.

For example, to add shared service from class \Services\OtherService with "otherService" identifier, which has constructor `__construct(\Services\Service $service, bool $status)` and require $status to set to true, use the following code:

```php
$myContainer->addShared('otherService', [
    'className' => \Services\OtherService::class,
    'arguments' => [
        'type' => 'service',
        'value' => \Services\Service::class
    ],
    [
        'type' => 'value',
        'value' => true
    ]
]);
```

The order of adding services to container is not important, because during construction of service all dependencies will be automatically resolved.

To get service object you can use the following code:

```php
$myContainer->get('otherService');
```

or:

```php
$myContainer->getOtherService();
```

Additionally you can check type of service by using the following method: `checkType(string $id, ServiceType $serviceType): bool`. You can also check if service exists in container by using the following method: `has($id): bool`.

You can also check how many services are defined in the container by using the following method: `count() : int`. Alternatively you can use the function `count()` on container to check this.

To control any wrong situations, there are the following exceptions available:

* `\Kocuj\Di\Container\Exception` - for problem with creating or getting service in container;
* `\Kocuj\Di\Container\NotFoundException` - for non-existent services;
* `\Kocuj\Di\Service\Exception` - for problems with service type; however, this exception will not be used when this library is used correctly;
* `\Kocuj\Di\ServiceSource\Exception` - for problems with service source.

Example of using the library:

```php
<?php

use Kocuj\Di\Di;

// initialize DI container
$di = new Di();
// get DI container
$container = $di->getDefault();
// set DI services
$container->addShared('input', [
    'className' => InputService::class
]);
$container->addShared('output', [
    'className' => OutputService::class
]);
$container->addStandard('main', [
    'className' => Main::class,
    'arguments' => [
        [
            'type' => 'service',
            'value' => 'input'
        ],
        [
            'type' => 'service',
            'value' => 'output'
        ]
    ]
]);
// execute
$container->get('main')->display();
```

For more information you can see examples included in this project or by looking on [project website](http://libs.kocuj.pl/en/kocuj-di).

## Testing

``` bash
$ vendor/bin/phpunit
```

## Creating programming documentation

``` bash
$ vendor/bin/phpdoc
```

## Contributing

Please see [CONTRIBUTING](https://github.com/kocuj/di/blob/master/CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please contact me by using [contact form on project website](http://libs.kocuj.pl/en/contact/) instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](https://github.com/kocuj/di/blob/master/LICENSE.md) for more information.
