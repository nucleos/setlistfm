<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\SetlistFm\Tests\Model;

use Nucleos\SetlistFm\Model\Venue;
use PHPUnit\Framework\TestCase;

final class VenueTest extends TestCase
{
    public function testFromApi(): void
    {
        $data = <<<'EOD'
                    {
                      "city" : {
                        "id" : "5357527",
                        "name" : "Hollywood",
                        "stateCode" : "CA",
                        "state" : "California",
                        "coords" : {
                          "long" : -118.3267434,
                          "lat" : 34.0983425
                        },
                        "country" : {
                          "code" : "US",
                          "name" : "United States"
                        }
                      },
                      "url" : "https://www.setlist.fm/venue/compaq-center-san-jose-ca-usa-6bd6ca6e.html",
                      "id" : "6bd6ca6e",
                      "name" : "Compaq Center"
                    }
EOD;

        $venue = Venue::fromApi(json_decode($data, true));
        self::assertSame('6bd6ca6e', $venue->getId());
        self::assertSame('Compaq Center', $venue->getName());
        self::assertNotNull($venue->getCity());
        self::assertSame('https://www.setlist.fm/venue/compaq-center-san-jose-ca-usa-6bd6ca6e.html', $venue->getUrl());
    }
}
