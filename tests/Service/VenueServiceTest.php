<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Tests\Service;

use Core23\SetlistFm\Builder\VenueSearchBuilder;
use Core23\SetlistFm\Connection\ConnectionInterface;
use Core23\SetlistFm\Service\VenueService;
use PHPUnit\Framework\TestCase;

final class VenueServiceTest extends TestCase
{
    private $connection;

    protected function setUp()
    {
        $this->connection =  $this->prophesize(ConnectionInterface::class);
    }

    public function testItIsInstantiable(): void
    {
        $service = new VenueService($this->connection->reveal());

        static::assertNotNull($service);
    }

    public function testGetVenue(): void
    {
        $rawResponse = <<<'EOD'
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

        $this->connection->call('venue/6bd6ca6e')
            ->willReturn(json_decode($rawResponse, true))
        ;

        $service = new VenueService($this->connection->reveal());
        $result  = $service->getVenue('6bd6ca6e');

        static::assertNotNull($result);
    }

    public function testSearch(): void
    {
        $rawResponse = <<<'EOD'
                   {
                     "venue" : [ {
                       "city" : {
                         "id" : "5357527",
                         "name" : "Hollywood",
                         "stateCode" : "CA",
                         "state" : "California",
                         "coords" : { },
                         "country" : { }
                       },
                       "url" : "https://www.setlist.fm/venue/compaq-center-san-jose-ca-usa-6bd6ca6e.html",
                       "id" : "6bd6ca6e",
                       "name" : "Compaq Center"
                     } ],
                     "total" : 1,
                     "page" : 1,
                     "itemsPerPage" : 20
                   }
EOD;

        $this->connection->call('search/venues', ['p' => 1, 'name' => 'Compaq Center'])
            ->willReturn(json_decode($rawResponse, true))
        ;

        $service = new VenueService($this->connection->reveal());
        $result  = $service->search(VenueSearchBuilder::create()
            ->withName('Compaq Center'));

        static::assertCount(1, $result->getResult());
    }
}
