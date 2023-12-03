<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\SetlistFm\Tests\Service;

use Nucleos\SetlistFm\Builder\ArtistSearchBuilder;
use Nucleos\SetlistFm\Connection\ConnectionInterface;
use Nucleos\SetlistFm\Service\ArtistService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class ArtistServiceTest extends TestCase
{
    /**
     * @var ConnectionInterface&MockObject
     */
    private ConnectionInterface $connection;

    protected function setUp(): void
    {
        $this->connection =  $this->createMock(ConnectionInterface::class);
    }

    public function testGetArtist(): void
    {
        $rawResponse = <<<'EOD'
                        {
                          "mbid" : "b10bbbfc-cf9e-42e0-be17-e2c3e1d2600d",
                          "tmid" : 735610,
                          "name" : "The Beatles",
                          "sortName" : "Beatles, The",
                          "disambiguation" : "John, Paul, George and Ringo",
                          "url" : "https://www.setlist.fm/setlists/the-beatles-23d6a88b.html"
                        }
EOD;

        $this->connection->method('call')->with('artist/b10bbbfc-cf9e-42e0-be17-e2c3e1d2600d')
            ->willReturn(json_decode($rawResponse, true))
        ;

        $service = new ArtistService($this->connection);
        $result  = $service->getArtist('b10bbbfc-cf9e-42e0-be17-e2c3e1d2600d');

        self::assertSame('b10bbbfc-cf9e-42e0-be17-e2c3e1d2600d', $result->getMbid());
    }

    public function testSearch(): void
    {
        $rawResponse = <<<'EOD'
                    {
                      "artist" : [ {
                        "mbid" : "b10bbbfc-cf9e-42e0-be17-e2c3e1d2600d",
                        "tmid" : 735610,
                        "name" : "The Beatles",
                        "sortName" : "Beatles, The",
                        "disambiguation" : "John, Paul, George and Ringo",
                        "url" : "https://www.setlist.fm/setlists/the-beatles-23d6a88b.html"
                      }],
                      "total" : 1,
                      "page" : 1,
                      "itemsPerPage" : 20
                    }
EOD;

        $this->connection->method('call')->with('search/artists', ['p' => 1, 'artistName' => 'The Beatles'])
            ->willReturn(json_decode($rawResponse, true))
        ;

        $service = new ArtistService($this->connection);
        $result  = $service->search(ArtistSearchBuilder::create()
            ->withName('The Beatles'));

        self::assertCount(1, $result->getResult());
    }
}
