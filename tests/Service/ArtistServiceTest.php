<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Tests\Service;

use Core23\SetlistFm\Builder\ArtistSearchBuilder;
use Core23\SetlistFm\Connection\ConnectionInterface;
use Core23\SetlistFm\Service\ArtistService;
use PHPUnit\Framework\TestCase;

class ArtistServiceTest extends TestCase
{
    private $connection;

    protected function setUp()
    {
        $this->connection =  $this->prophesize(ConnectionInterface::class);
    }

    public function testItIsInstantiable(): void
    {
        $service = new ArtistService($this->connection->reveal());

        static::assertNotNull($service);
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

        $this->connection->call('artist/b10bbbfc-cf9e-42e0-be17-e2c3e1d2600d')
            ->willReturn(json_decode($rawResponse, true))
        ;

        $service = new ArtistService($this->connection->reveal());
        $result  = $service->getArtist('b10bbbfc-cf9e-42e0-be17-e2c3e1d2600d');

        static::assertNotNull($result);
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

        $this->connection->call('search/artists', ['p' => 1, 'artistName' => 'The Beatles'])
            ->willReturn(json_decode($rawResponse, true))
        ;

        $service = new ArtistService($this->connection->reveal());
        $result  = $service->search(ArtistSearchBuilder::create()
            ->withName('The Beatles'));

        static::assertCount(1, $result->getResult());
    }
}
