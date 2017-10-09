# Kocuj DI
Kontener dla wzorca projektowego "wstrzykiwanie zależności" (Dependency Injection) dla PHP 7

[![Autor](http://img.shields.io/badge/author-kocuj.pl-blue.svg?style=flat-square)](http://kocuj.pl)
[![Najnowsza wersja](https://img.shields.io/github/release/kocuj/di.svg?style=flat-square)](https://github.com/kocuj/di/releases)
[![Licencja](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://github.com/kocuj/di/blob/master/LICENSE.md)
[![Status pokrycia kodu](https://img.shields.io/scrutinizer/coverage/g/kocuj/di.svg?style=flat-square)](https://scrutinizer-ci.com/g/kocuj/di/code-structure)
[![Punkty za jakość](https://img.shields.io/scrutinizer/g/kocuj/di.svg?style=flat-square)](https://scrutinizer-ci.com/g/kocuj/di)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/8445db3c-571b-48e3-a71b-e46de879c955/big.png)](https://insight.sensiolabs.com/projects/8445db3c-571b-48e3-a71b-e46de879c955)

Niniejszy pakiet jest zgodny z [PSR-1](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md), [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) and [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md). Jeżeli zauważyłeś niezgodność, proszę abyś wysłał poprawkę przez prośbę o pociągnięcie danych ("pull request").

## Instalacja

Przy użyciu Composera:

``` bash
$ composer require kocuj/di
```

## Wymagania

Następujące wersje PHP są obsługiwane przez tą wersję:

* PHP 7.0
* PHP 7.1

## Dokumentacja

Przykład użycia biblioteki:

```php
<?php

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

Więcej informacji możesz uzyskać przeglądając przykłady dołączone do projektu lub zaglądając na [stronę internetową projektu](http://libs.kocuj.pl/pl/kocuj-di).

## Testowanie

``` bash
$ vendor/bin/phpunit
```

## Współpraca

Proszę zobaczyć [informacje o współpracy](https://github.com/kocuj/di/blob/master/CONTRIBUTING.pl.md) w celu uzyskania szczegółów.

## Bezpieczeństwo

Jeżeli odkryłeś jakikolwiek problem z bezpieczeństwem, proszę abyś się ze mną skontaktował używając [formularza kontaktowego na stronie internetowej projektu](http://libs.kocuj.pl/pl/kontakt/), zamiast zgłaszać publiczny błąd.

## Licencja

Licencja MIT. Proszę zapoznać się z [plikiem licencji](https://github.com/kocuj/di/blob/master/LICENSE.md) (tylko w języku angielskim), aby uzyskać więcej informacji.

## Czy mogę Cię wynająć do innych projektów programistycznych?

Tak! Zobacz moją domową stronę internetową [kocuj.pl](http://kocuj.pl/) lub po prostu pozostaw mi informację używając [formularza kontaktowego](http://libs.kocuj.pl/pl/contact).
