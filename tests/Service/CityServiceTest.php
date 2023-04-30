<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\SetlistFm\Tests\Service;

use Nucleos\SetlistFm\Builder\CitySearchBuilder;
use Nucleos\SetlistFm\Connection\ConnectionInterface;
use Nucleos\SetlistFm\Service\CityService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class CityServiceTest extends TestCase
{
    /**
     * @var ConnectionInterface&MockObject
     */
    private ConnectionInterface $connection;

    protected function setUp(): void
    {
        $this->connection =  $this->createMock(ConnectionInterface::class);
    }

    public function testGetCity(): void
    {
        $rawResponse = <<<'EOD'
                        {
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
                        }
EOD;

        $this->connection->method('call')->with('city/5357527')
            ->willReturn(json_decode($rawResponse, true))
        ;

        $service = new CityService($this->connection);
        $result  = $service->getCity(5357527);

        static::assertSame('Hollywood', $result->getName());
    }

    public function testSearch(): void
    {
        $rawResponse = <<<'EOD'
                   {
                     "cities" : [ {
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
                     } ],
                     "total" : 1,
                     "page" : 1,
                     "itemsPerPage" : 20
                   }
EOD;

        $this->connection->method('call')->with('search/cities', ['p' => 1, 'name' => 'Hollywood'])
            ->willReturn(json_decode($rawResponse, true))
        ;

        $service = new CityService($this->connection);
        $result  = $service->search(CitySearchBuilder::create()
            ->withName('Hollywood'));

        static::assertCount(1, $result->getResult());
    }
}
