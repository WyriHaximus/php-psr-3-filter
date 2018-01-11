# [PSR-3](http://www.php-fig.org/psr/psr-3/) Filter decorators

[![Linux Build Status](https://travis-ci.org/WyriHaximus/php-psr-3-filter.png)](https://travis-ci.org/WyriHaximus/php-psr-3-filter)
[![Latest Stable Version](https://poser.pugx.org/WyriHaximus/psr-3-filter/v/stable.png)](https://packagist.org/packages/WyriHaximus/psr-3-filter)
[![Total Downloads](https://poser.pugx.org/WyriHaximus/psr-3-filter/downloads.png)](https://packagist.org/packages/WyriHaximus/psr-3-filter/stats)
[![Code Coverage](https://scrutinizer-ci.com/g/WyriHaximus/php-psr-3-filter/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/WyriHaximus/php-psr-3-filter/?branch=master)
[![License](https://poser.pugx.org/WyriHaximus/psr-3-filter/license.png)](https://packagist.org/packages/wyrihaximus/psr-3-filter)
[![PHP 7 ready](http://php7ready.timesplinter.ch/WyriHaximus/php-psr-3-filter/badge.svg)](https://travis-ci.org/WyriHaximus/php-psr-3-filter)

### Installation ###

To install via [Composer](http://getcomposer.org/), use the command below, it will automatically detect the latest version and bind it with `^`.

```
composer require wyrihaximus/psr-3-filter 
```

## Context Filter ##

```php
$level2 = ['bad', 'evil'];
$monolog = new Monolog(); // Any PSR-3 logger
$filterredLogger = new ContextFilterLogger('level1.level2', $level2, $monolog);
$filterredLogger->info('bad', [
    'level1' => [
        'level2' => 'bad',
    ],
]); // Will reach monolog
$filterredLogger->info('good', [
    'level1' => [
        'level2' => 'good',
    ],
]); // Won't reach monolog
$filterredLogger->info('evil', [
    'level1' => [
        'level2' => 'evil',
    ],
]); // Will reach monolog
```

## Log Level Filter ##

```php
$monolog = new Monolog(); // Any PSR-3 logger
$filterredLogger = new LogLevelFilterLogger(['error, $monolog);
$filterredLogger->error('bad'); // Won't reach monolog
$filterredLogger->info('good'); // Will reach monolog
$filterredLogger->error('evil'); // Won't reach monolog
```

## Message Keyword Filter ##

```php
$keywords = ['bad', 'evil'];
$monolog = new Monolog(); // Any PSR-3 logger
$filterredLogger = new MessageKeywordFilterLogger($keywords, $monolog);
$filterredLogger->info('bad'); // Won't reach monolog
$filterredLogger->info('good'); // Will reach monolog
$filterredLogger->info('evil'); // Won't reach monolog
```

## Contributing ##

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License ##

Copyright 2018 [Cees-Jan Kiewiet](http://wyrihaximus.net/)

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.
