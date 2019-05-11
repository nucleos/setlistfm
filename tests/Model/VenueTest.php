<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Tests\Model;

use Core23\SetlistFm\Model\Venue;
use PHPUnit\Framework\TestCase;

class VenueTest extends TestCase
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
        static::assertSame('6bd6ca6e', $venue->getId());
        static::assertSame('Compaq Center', $venue->getName());
        static::assertNotNull($venue->getCity());
        static::assertSame('https://www.setlist.fm/venue/compaq-center-san-jose-ca-usa-6bd6ca6e.html', $venue->getUrl());
    }
}
