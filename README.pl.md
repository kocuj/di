# Kocuj DI
Kontener dla wzorca projektowego "wstrzykiwanie zależności" (Dependency Injection) dla PHP 7

[![Autor](http://img.shields.io/badge/author-kocuj.pl-blue.svg?style=flat-square)](http://kocuj.pl)
[![Najnowsza wersja](https://img.shields.io/github/release/kocuj/di.svg?style=flat-square)](https://github.com/kocuj/di/releases)
[![Problemy](https://img.shields.io/github/issues/kocuj/di)](https://github.com/kocuj/di/issues)
[![Oczekujące prośby o pociągnięcie danych](https://img.shields.io/github/issues-pr/kocuj/di)](https://github.com/kocuj/di/pulls)
[![Licencja](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://github.com/kocuj/di/blob/master/LICENSE.md)
![Status budowy](https://github.com/kocuj/di/actions/workflows/build.yml/badge.svg)
[![Status pokrycia kodu](https://img.shields.io/scrutinizer/coverage/g/kocuj/di.svg?style=flat-square)](https://scrutinizer-ci.com/g/kocuj/di/code-structure)
[![Punkty za jakość](https://img.shields.io/scrutinizer/g/kocuj/di.svg?style=flat-square)](https://scrutinizer-ci.com/g/kocuj/di)
[![Całkowita ilość pobrań](https://img.shields.io/packagist/dt/kocuj/di.svg?style=flat-square)](https://packagist.org/packages/kocuj/di)

Niniejszy pakiet jest zgodny z [PSR-1](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md), [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md), [PSR-11](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-11-container.md) i [PSR-12](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-12-extended-coding-style-guide.md). Jeżeli zauważyłeś niezgodność, proszę abyś wysłał poprawkę przez prośbę o pociągnięcie danych ("pull request").

## [Pobierz 2.0.0](https://github.com/kocuj/di/releases/tag/v2.0.0)

NIE UŻYWAJ TEJ GAŁĘZI NA PRODUKCJI! TA GAŁĄŹ ISTNIEJE TYLKO DLA PROGRAMOWANIA WERSJI 2.0.

## Instalacja

Przy użyciu Composera:

``` bash
composer require kocuj/di
```

## Wymagania

Następujące wersje PHP są obsługiwane przez tą wersję:
 
* PHP 7.4

## Dokumentacja

W niniejszej dokumentacji zakłada się, że zaimportujesz przestrzenie nazw dla biblioteki Kocuj DI używając następującego kodu:

```php
use Kocuj\Di\Di;
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
`add(ServiceType $serviceType, string $id, $serviceSource): ContainerInterface`

Argument $serviceType może być jednym z następujących:

* aby utworzyć serwis współdzielony - `new ServiceType(ServiceType::SHARED)`;
* aby utworzyć serwis standardowy - `new ServiceType(ServiceType::STANDARD)`.

Jeżeli chcesz pominąć argument $serviceType, możesz użyć jednej z następujących metod:

* aby utworzyć serwis współdzielony - `addShared(string $id, $serviceSource): ContainerInterface`;
* aby utworzyć serwis standardowy - `addStandard(string $id, $serviceSource): ContainerInterface`.

Argument $id jest identyfikatorem utworzonego serwisu. Wszystkie identyfikatory są automatycznie zmieniane na format "camelCase". Pamiętaj, że wewnątrz jednego kontenera możesz być tylko jeden serwis o wybranym identyfikatorze.

Argument $serviceSource jest serwisem używanym z wybranym identyfikatorem. Argument ten może być jednym z następujących typów:

* obiekt - ten obiekt będzie używany jako serwis;
* funkcja anonimowa - ta funkcja nie posiada argumentów i powinna zwrócić obiekt, który będzie używany jako serwis;
* klasa - powinna to być tablica z następującymi elementami:
  * `className` - wymagany element; jest to w pełni kwalifikowana nazwa klasy serwisu (dobrą praktyką jest użycie notacji "::class" w tym miejscu);
  * `arguments` - opcjonalny element; więcej informacji o tym elemencie znajduje się poniżej w niniejszej dokumentacji.

Najlepszą funkcjonalnością biblioteki Kocuj DI jest automatyczne rozwiązywanie zależności pomiędzy serwisami, gdy argument $serviceSource jest tablicą. Aby użyć tej funkcjonalności, powinien być przynajmniej jeden argument wysłany do konstruktora serwisu. Miejscem do wykonania tego jest element "arguments" wewnątrz tablicy w argumencie $serviceSource.

Każdy argument w $arguments zawiera tablicę z jednym elementem z indeksem "type" i z drugim z indeksem "value", którego wartość zależy od wartości ustawionej w indeksie "type". Element z indeksem "type" zawiera nazwę typu argumentu.

Istnieją dwa typy argumentów wybierane przez element z indeksem "type":

* "service" - aby ustawić serwis do pobrania, musi istnieć drugi element w tablicy z indeksem "value" zawierającym identyfikator serwisu;
* "value" - aby ustawić wartość, musi istnieć drugi element w tablicy z indeksem "value" zawierającym tą wartość.

Na przykład, aby dodać serwis współdzielony z klasy \Services\OtherService z identyfikatorem "otherService", który posiada konstruktor `__construct(\Services\Service $service, bool $status)` i wymaga, aby $status był ustawiony na true, użyj następującego kodu:

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

Możesz również sprawdzić ile serwisów jest zdefiniowanych w kontenerze używając następującej metody: `count() : int`. Alternatywnie możesz użyć funkcji `count()` na kontenerze, aby to sprawdzić.

Aby kontrolować wszystkie nieprawidłowe sytuacje, istnieją następujące wyjątki:

* `\Kocuj\Di\Container\Exception` - dla problemów z tworzeniem lub pobieraniem serwisu w kontenerze;
* `\Kocuj\Di\Container\NotFoundException` - dla nieistniejących serwisów;
* `\Kocuj\Di\Service\Exception` - dla problemów z typem serwisu; jednakże ten wyjątek nie będzie używany, gdy biblioteka jest używana poprawnie;
* `\Kocuj\Di\ServiceSource\Exception` - dla problemów ze źródłem serwisu.

Przykład użycia biblioteki:

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

Więcej informacji możesz uzyskać przeglądając przykłady dołączone do projektu lub zaglądając na [stronę internetową projektu](http://libs.kocuj.pl/pl/kocuj-di).

## Środowisko programistyczne

W celu wzięcia udziału w programowaniu tego projektu można wykorzystać konfigurację dla Dockera. Aby ją przygotować, powinieneś użyć następującej komendy:

``` bash
docker-compose build
```

Następnie możesz uruchomić kontener Dockera używając następującej komendy:

``` bash
docker-compose up -d
```

Od teraz możesz wywoływać komendy w kontenerze Dockera. Obecnie istnieje jeden kontener `kocujdi_74` z PHP 7.4. Aby wywołać jakieś komendy wewnątrz niego powinieneś wpisać:

``` bash
docker exec -it kocujdi_php74 COMMAND
```

gdzie `COMMAND` to komenda do wykonania wewnątrz kontenera Dockera, np. `bash`.

## Testowanie

``` bash
vendor/bin/phpunit
```

Opcjonalnie możesz to zrobić w kontenerze Dockera:

``` bash
docker exec -it kocujdi_php74 vendor/bin/phpunit
```

## Tworzenie dokumentacji programistycznej

``` bash
vendor/bin/phpdoc
```

## Współpraca

Proszę zobaczyć [informacje o współpracy](https://github.com/kocuj/di/blob/master/CONTRIBUTING.pl.md) w celu uzyskania szczegółów.

## Bezpieczeństwo

Jeżeli odkryłeś jakikolwiek problem z bezpieczeństwem, proszę abyś się ze mną skontaktował używając [formularza kontaktowego na stronie internetowej projektu](http://libs.kocuj.pl/pl/contact/), zamiast zgłaszać publiczny błąd.

## Licencja

Licencja MIT. Proszę zapoznać się z [plikiem licencji](https://github.com/kocuj/di/blob/master/LICENSE.md) (tylko w języku angielskim), aby uzyskać więcej informacji.
