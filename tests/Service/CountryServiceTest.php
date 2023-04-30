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
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class CountryServiceTest extends TestCase
{
    /**
     * @var ConnectionInterface&MockObject
     */
    private ConnectionInterface $connection;

    protected function setUp(): void
    {
        $this->connection =  $this->createMock(ConnectionInterface::class);
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

        $this->connection->method('call')->with('search/countries')
            ->willReturn(json_decode($rawResponse, true))
        ;

        $service = new CountryService($this->connection);
        $result  = $service->search();

        static::assertCount(1, $result->getResult());
    }
}
