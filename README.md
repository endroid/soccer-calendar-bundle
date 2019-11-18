# Soccer Calendar Bundle

*By [endroid](https://endroid.nl/)*

[![Latest Stable Version](http://img.shields.io/packagist/v/endroid/soccer-calendar-bundle.svg)](https://packagist.org/packages/endroid/soccer-calendar-bundle)
[![Build Status](https://github.com/endroid/soccer-calendar-bundle/workflows/CI/badge.svg)](https://github.com/endroid/soccer-calendar-bundle/actions)
[![Total Downloads](http://img.shields.io/packagist/dt/endroid/soccer-calendar-bundle.svg)](https://packagist.org/packages/endroid/soccer-calendar-bundle)
[![Monthly Downloads](http://img.shields.io/packagist/dm/endroid/soccer-calendar-bundle.svg)](https://packagist.org/packages/endroid/soccer-calendar-bundle)
[![License](http://img.shields.io/packagist/l/endroid/soccer-calendar-bundle.svg)](https://packagist.org/packages/endroid/soccer-calendar-bundle)

This bundle integrates the endroid/soccer-calendar library in your project.

## Installation

Use [Composer](https://getcomposer.org/) to install the library.

``` bash
$ composer require endroid/soccer-calendar-bundle
```

## Symfony integration

Register the Symfony bundle in the kernel.

```php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = [
        // ...
        new Endroid\SoccerCalendar\SoccerCalendarBundle\EndroidSoccerCalendarBundle(),
    ];
}
```

Add the following section to your routing.

``` yml
EndroidSoccerCalendarBundle:
    resource: "@EndroidSoccerCalendarBundle/Controller/"
    type:     annotation
    prefix:   /soccer-calendar
```

## Versioning

Version numbers follow the MAJOR.MINOR.PATCH scheme. Backwards compatibility
breaking changes will be kept to a minimum but be aware that these can occur.
Lock your dependencies for production and test your code when upgrading.

## License

This bundle is under the MIT license. For the full copyright and license
information please view the LICENSE file that was distributed with this source code.
