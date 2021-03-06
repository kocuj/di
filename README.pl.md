# Kocuj DI
Kontener dla wzorca projektowego "wstrzykiwanie zależności" (Dependency Injection) dla PHP 7

[![Autor](http://img.shields.io/badge/author-kocuj.pl-blue.svg?style=flat-square)](http://kocuj.pl)
[![Najnowsza wersja](https://img.shields.io/github/release/kocuj/di.svg?style=flat-square)](https://github.com/kocuj/di/releases)
[![Problemy](http://githubbadges.herokuapp.com/kocuj/di/issues.svg)](https://github.com/kocuj/di/issues)
[![Oczekujące prośby o pociągnięcie danych](http://githubbadges.herokuapp.com/kocuj/di/pulls.svg)](https://github.com/kocuj/di/pulls)
[![Licencja](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://github.com/kocuj/di/blob/master/LICENSE.md)
[![Status budowy](https://img.shields.io/travis/kocuj/di/master.svg?style=flat-square)](https://travis-ci.org/kocuj/di)
[![Status pokrycia kodu](https://img.shields.io/scrutinizer/coverage/g/kocuj/di.svg?style=flat-square)](https://scrutinizer-ci.com/g/kocuj/di/code-structure)
[![Punkty za jakość](https://img.shields.io/scrutinizer/g/kocuj/di.svg?style=flat-square)](https://scrutinizer-ci.com/g/kocuj/di)
[![Całkowita ilość pobrań](https://img.shields.io/packagist/dt/kocuj/di.svg?style=flat-square)](https://packagist.org/packages/kocuj/di)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/8445db3c-571b-48e3-a71b-e46de879c955/big.png)](https://insight.sensiolabs.com/projects/8445db3c-571b-48e3-a71b-e46de879c955)

Niniejszy pakiet jest zgodny z [PSR-1](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md), [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md), [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md) i [PSR-11](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-11-container.md). Jeżeli zauważyłeś niezgodność, proszę abyś wysłał poprawkę przez prośbę o pociągnięcie danych ("pull request").

## [Pobierz 1.4.1](https://github.com/kocuj/di/releases/tag/v1.4.1)

## Instalacja

Przy użyciu Composera:

``` bash
$ composer require kocuj/di
```

## Wymagania

Następujące wersje PHP są obsługiwane przez tą wersję:

* PHP 7.0
* PHP 7.1
* PHP 7.2
* PHP 7.3

## Dokumentacja

W niniejszej dokumentacji zakłada się, że zaimportujesz przestrzenie nazw dla biblioteki Kocuj DI używając następującego kodu:

```php
use Kocuj\Di\Di;
use Kocuj\Di\Service\ServiceType\ServiceType;
```

Aby użyć biblioteki Kocuj DI musisz najpierw zainicjalizować ją:

```php
$di = new Di();
```

Utworzy to obiekt biblioteki Kocuj DI. Możesz utworzyć więcej obiektów Di, ale nie jest to zalecane. Lepszym rozwiązaniem jest utworzenie większej ilości kontenerów DI, co zostanie wyjaśnione w dalszej części niniejszej dokumentacji.

Po skonstruowaniu, zmienna $di będzie zawierała jeden kontener do wstrzykiwania zależności, które możesz pobrać używając następującego kodu:

```php
$defaultContainer = $di->getDefault();
```

Możesz też utworzyć więcej kontenerów:

```php
$myContainer = $di->create();
```

Możesz także utworzyć nowy kontener bazujący na już istniejącym kontenerze używając następującego kodu:

```php
$myContainer = $di->copy($oldContainer);
```

Od tego momentu możesz używać nowego kontenera używając metod na zmiennej $myContainer. Jednakże niniejsza dokumentacja będzie używała domyślnego kontenera do wyjaśnień dotyczących używania biblioteki Kocuj DI.

Po utworzeniu kontenera (domyślnego lub innego), możesz dodać serwisy do niego. Istnieją dwa typy serwisów:

* współdzielony ("shared") - serwis, który będzie skonstruowany tylko raz, tak jak we wzorcu projektowym "singleton";
* standardowy ("standard") - serwis, który będzie konstruowany przy każdym użyciu.

Aby utworzyć serwis, możesz użyć następującej metody:
`add(ServiceType $serviceType, string $id, string $source, array $arguments = []): ContainerInterface`

Argument $serviceType może być jednym z następujących:

* aby utworzyć serwis współdzielony - `new ServiceType(ServiceType::SHARED)`;
* aby utworzyć serwis standardowy - `new ServiceType(ServiceType::STANDARD)`.

Jeżeli chcesz pominąć argument $serviceType, możesz użyć jednej z następujących metod:

* aby utworzyć serwis współdzielony - `addShared(string $id, string $source, array $arguments = []): ContainerInterface`;
* aby utworzyć serwis standardowy - `addStandard(string $id, string $source, array $arguments = []): ContainerInterface`.

Argument $id jest identyfikatorem utworzonego serwisu. Wszystkie identyfikatory są automatycznie zmieniane na format "camelCase". Pamiętaj, że wewnątrz jednego kontenera możesz być tylko jeden serwis o wybranym identyfikatorze.

Argument $source to w pełni kwalifikowana nazwa klasy dla serwisu. Dobrą praktyką jest użycie notacji "::class" w tym miejscu.

Na przykład, aby dodać serwis współdzielony z klasy \Services\Service z identyfikatorem "someService", użyj następującego kodu:

```php
$myContainer->addShared('someService', \Services\Service::class);
```

Jednakże najlepszą funkcjonalnością biblioteki Kocuj DI jest automatyczne rozwiązywanie zależności pomiędzy serwisami. Aby użyć tej funkcjonalności, powinien być przynajmniej jeden argument wysłany do konstruktora serwisu. Miejscem do wykonania tego jest argument $arguments.

Każdy argument w $arguments zawiera tablicę z jednym elementem z indeksem "type" i z drugim z indeksem "value", którego wartość zależy od wartości ustawionej w indeksie "type". Element z indeksem "type" zawiera nazwę typu argumentu.

Istnieją dwa typy argumentów wybierane przez element z indeksem "type":

* "service" - aby ustawić serwis do pobrania, musi istnieć drugi element w tablicy z indeksem "value" zawierającym identyfikator serwisu;
* "value" - aby ustawić wartość, musi istnieć drugi element w tablicy z indeksem "value" zawierającym tą wartość.

Na przykład, aby dodać serwis współdzielony z klasy \Services\OtherService z identyfikatorem "otherService", który posiada konstruktor `__construct(\Services\Service $service, bool $status)` i wymaga, aby $status był ustawiony na true, użyj następującego kodu:

```php
$myContainer->addShared('otherService', \Services\OtherService::class, [
    [
        'type' => 'service',
        'value' => \Services\Service::class
    ],
    [
        'type' => 'value',
        'value' => true
    ]
]);
```

Kolejność dodawania serwisów do kontenera nie jest ważna, ponieważ podczas konstrukcji serwisu wszystkie zależności będą automatycznie rozwiązane.

Aby pobrać obiekt serwisu, możesz użyć następującego kodu:

```php
$myContainer->get('otherService');
```

lub:

```php
$myContainer->getOtherService();
```

Dodatkowo możesz sprawdzić typ serwisu używając następującej metody: `checkType(string $id, ServiceType $serviceType): bool`. Możesz też sprawdzić, czy serwis istnieje w kontenerze używając następującej metody: `has($id): bool`.

Aby kontrolować wszystkie nieprawidłowe sytuacje, istnieją następujące wyjątki:

* `\Kocuj\Di\ArgumentParser\Exception` - dla problemów z argumentem z innymi serwisami i/lub wartościami dla tworzonego serwisu;
* `\Kocuj\Di\Container\Exception` - dla problemów z tworzeniem lub pobieraniem serwisu w kontenerze;
* `\Kocuj\Di\Service\Exception` - dla problemów z typem serwisu; jednakże ten wyjątek nie będzie używany, gdy biblioteka jest używana poprawnie.

Przykład użycia biblioteki:

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
        'value' => 'input'
    ],
    [
        'type' => 'service',
        'value' => 'output'
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

## Tworzenie dokumentacji programistycznej

``` bash
$ vendor/bin/phpdoc
```

## Współpraca

Proszę zobaczyć [informacje o współpracy](https://github.com/kocuj/di/blob/master/CONTRIBUTING.pl.md) w celu uzyskania szczegółów.

## Bezpieczeństwo

Jeżeli odkryłeś jakikolwiek problem z bezpieczeństwem, proszę abyś się ze mną skontaktował używając [formularza kontaktowego na stronie internetowej projektu](http://libs.kocuj.pl/pl/contact/), zamiast zgłaszać publiczny błąd.

## Licencja

Licencja MIT. Proszę zapoznać się z [plikiem licencji](https://github.com/kocuj/di/blob/master/LICENSE.md) (tylko w języku angielskim), aby uzyskać więcej informacji.

## Czy mogę Cię wynająć do innych projektów programistycznych?

Tak! Zobacz moją domową stronę internetową [kocuj.pl](http://kocuj.pl/) lub po prostu pozostaw mi informację używając [formularza kontaktowego](http://kocuj.pl/kontakt).
