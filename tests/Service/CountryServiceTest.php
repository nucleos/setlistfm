<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\SetlistFm\Tests\Service;

use Nucleos\SetlistFm\Connection\ConnectionInterface;
use Nucleos\SetlistFm\Service\CountryService;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;

final class CountryServiceTest extends TestCase
{
    /**
     * @var ObjectProphecy
     */
    private $connection;

    protected function setUp(): void
    {
        $this->connection =  $this->prophesize(ConnectionInterface::class);
    }

    public function testSearch(): void
    {
        $rawResponse = <<<'EOD'
                    {
                      "country" : [ {
                        "code" : "US",
                        "name" : "United States"
                      }],
                      "total" : 1,
                      "page" : 1,
                      "itemsPerPage" : 20
                    }
EOD;

        $this->connection->call('search/countries')
            ->willReturn(json_decode($rawResponse, true))
        ;

        $service = new CountryService($this->connection->reveal());
        $result  = $service->search();

        static::assertCount(1, $result->getResult());
    }
}
