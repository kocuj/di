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

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/8445db3c-571b-48e3-a71b-e46de879c955/big.png)](https://insight.sensiolabs.com/projects/8445db3c-571b-48e3-a71b-e46de879c955)

This package is compliant with [PSR-1](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md), [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) and [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md). If you notice compliance oversights, please send a patch via pull request.

## [Download 1.1.0](https://github.com/kocuj/di/releases/tag/v1.1.0)

## Install

Via Composer:

``` bash
$ composer require kocuj/di
```

## Requirements

The following versions of PHP are supported by this version:

* PHP 7.0
* PHP 7.1

## Documentation

Example of using the library:

```php
<?php

use Kocuj\Di\Di;

// initialize DI container
$di = new Di();
// get DI container
$container = $di->getDefault();
// set DI services
$container->addShared('input', InputService::class);
$container->addShared('output', OutputService::class);
$container->addStandard('main', Main::class, [
    [
        'type' => 'service',
        'service' => 'input'
    ],
    [
        'type' => 'service',
        'service' => 'output'
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

## Contributing

Please see [CONTRIBUTING](https://github.com/kocuj/di/blob/master/CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please contact me by using [contact form on project website](http://libs.kocuj.pl/en/contact/) instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](https://github.com/kocuj/di/blob/master/LICENSE.md) for more information.

## Can I hire you to other programming projects?

Yes! Visit my homepage [kocuj.pl](http://kocuj.pl/) (currently only in Polish language) or simply leave me a note by using the [contact form](http://libs.kocuj.pl/en/contact).
