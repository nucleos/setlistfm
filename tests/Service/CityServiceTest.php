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
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;

final class CityServiceTest extends TestCase
{
    /**
     * @var ObjectProphecy<ConnectionInterface>
     */
    private $connection;

    protected function setUp(): void
    {
        $this->connection =  $this->prophesize(ConnectionInterface::class);
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

        $this->connection->call('city/5357527')
            ->willReturn(json_decode($rawResponse, true))
        ;

        $service = new CityService($this->connection->reveal());
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

        $this->connection->call('search/cities', ['p' => 1, 'name' => 'Hollywood'])
            ->willReturn(json_decode($rawResponse, true))
        ;

        $service = new CityService($this->connection->reveal());
        $result  = $service->search(CitySearchBuilder::create()
            ->withName('Hollywood'));

        static::assertCount(1, $result->getResult());
    }
}
