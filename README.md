Setlist.fm PHP library
======================
[![Latest Stable Version](https://poser.pugx.org/nucleos/setlistfm/v/stable)](https://packagist.org/packages/nucleos/setlistfm)
[![Latest Unstable Version](https://poser.pugx.org/nucleos/setlistfm/v/unstable)](https://packagist.org/packages/nucleos/setlistfm)
[![License](https://poser.pugx.org/nucleos/setlistfm/license)](LICENSE.md)

[![Total Downloads](https://poser.pugx.org/nucleos/setlistfm/downloads)](https://packagist.org/packages/nucleos/setlistfm)
[![Monthly Downloads](https://poser.pugx.org/nucleos/setlistfm/d/monthly)](https://packagist.org/packages/nucleos/setlistfm)
[![Daily Downloads](https://poser.pugx.org/nucleos/setlistfm/d/daily)](https://packagist.org/packages/nucleos/setlistfm)

[![Continuous Integration](https://github.com/nucleos/setlistfm/workflows/Continuous%20Integration/badge.svg)](https://github.com/nucleos/setlistfm/actions)
[![Code Coverage](https://codecov.io/gh/nucleos/setlistfm/branch/main/graph/badge.svg)](https://codecov.io/gh/nucleos/setlistfm)

This library provides a wrapper for using the [Setlist.fm API] inside PHP and a bridge for symfony.

## Installation

Open a command console, enter your project directory and execute the following command to download the latest stable version of this library:

```
composer require nucleos/setlistfm
# To define a default http client and message factory
composer require symfony/http-client nyholm/psr7
```

## Usage

### General usage
```php
// Create connection
use Nucleos\SetlistFm\Builder\ArtistSearchBuilder;use Nucleos\SetlistFm\Connection\PsrClientConnection;use Nucleos\SetlistFm\Service\ArtistService;$connection = new PsrClientConnection($httpClient, $requestFactory);

$artistApi = new ArtistService($connection);
$artists = $artistApi->search(ArtistSearchBuilder::create()
    ->withArtistName('Slipknot')
);
```

## License

This library is under the [MIT license](LICENSE.md).

[Setlist.fm API]: https://api.setlist.fm
