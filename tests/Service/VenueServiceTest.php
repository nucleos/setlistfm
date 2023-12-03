<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\SetlistFm\Tests\Service;

use Nucleos\SetlistFm\Builder\VenueSearchBuilder;
use Nucleos\SetlistFm\Connection\ConnectionInterface;
use Nucleos\SetlistFm\Service\VenueService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class VenueServiceTest extends TestCase
{
    /**
     * @var ConnectionInterface&MockObject
     */
    private ConnectionInterface $connection;

    protected function setUp(): void
    {
        $this->connection =  $this->createMock(ConnectionInterface::class);
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

        $this->connection->method('call')->with('venue/6bd6ca6e')
            ->willReturn(json_decode($rawResponse, true))
        ;

        $service = new VenueService($this->connection);
        $result  = $service->getVenue('6bd6ca6e');

        self::assertSame('6bd6ca6e', $result->getId());
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

        $this->connection->method('call')->with('search/venues', ['p' => 1, 'name' => 'Compaq Center'])
            ->willReturn(json_decode($rawResponse, true))
        ;

        $service = new VenueService($this->connection);
        $result  = $service->search(VenueSearchBuilder::create()
            ->withName('Compaq Center'));

        self::assertCount(1, $result->getResult());
    }
}
