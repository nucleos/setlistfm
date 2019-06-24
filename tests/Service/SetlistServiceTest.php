<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Tests\Service;

use Core23\SetlistFm\Builder\SetlistSearchBuilder;
use Core23\SetlistFm\Connection\ConnectionInterface;
use Core23\SetlistFm\Service\SetlistService;
use PHPUnit\Framework\TestCase;

final class SetlistServiceTest extends TestCase
{
    private $connection;

    protected function setUp()
    {
        $this->connection =  $this->prophesize(ConnectionInterface::class);
    }

    public function testItIsInstantiable(): void
    {
        $service = new SetlistService($this->connection->reveal());

        static::assertNotNull($service);
    }

    public function testGetSetlist(): void
    {
        $rawResponse = <<<'EOD'
                       {
                         "artist" : {
                           "mbid" : "b10bbbfc-cf9e-42e0-be17-e2c3e1d2600d",
                           "tmid" : 735610,
                           "name" : "The Beatles",
                           "sortName" : "Beatles, The",
                           "disambiguation" : "John, Paul, George and Ringo",
                           "url" : "https://www.setlist.fm/setlists/the-beatles-23d6a88b.html"
                         },
                         "venue" : {
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
                         },
                         "tour" : {
                           "name" : "North American Tour 1964"
                         },
                         "info" : "Recorded and published as 'The Beatles at the Hollywood Bowl'",
                         "url" : "https://www.setlist.fm/setlist/the-beatles/1964/hollywood-bowl-hollywood-ca-63de4613.html",
                         "id" : "63de4613",
                         "versionId" : "7be1aaa0",
                         "eventDate" : "23-08-1964",
                         "lastUpdated" : "2013-10-20T05:18:08.000+0000"
                       }
EOD;

        $this->connection->call('setlist/63de4613')
            ->willReturn(json_decode($rawResponse, true))
        ;

        $service = new SetlistService($this->connection->reveal());
        $result  = $service->getSetlist('63de4613');

        static::assertNotNull($result);
    }

    public function testGetArtistSetlists(): void
    {
        $rawResponse = <<<'EOD'
                       {
                         "setlist" : [ {
                           "artist" : {
                             "mbid" : "b10bbbfc-cf9e-42e0-be17-e2c3e1d2600d",
                             "tmid" : 735610,
                             "name" : "The Beatles",
                             "sortName" : "Beatles, The",
                             "disambiguation" : "John, Paul, George and Ringo",
                             "url" : "https://www.setlist.fm/setlists/the-beatles-23d6a88b.html"
                           },
                           "venue" : {
                             "city" : { },
                             "url" : "https://www.setlist.fm/venue/compaq-center-san-jose-ca-usa-6bd6ca6e.html",
                             "id" : "6bd6ca6e",
                             "name" : "Compaq Center"
                           },
                           "tour" : {
                             "name" : "North American Tour 1964"
                           },
                           "info" : "Recorded and published as 'The Beatles at the Hollywood Bowl'",
                           "url" : "https://www.setlist.fm/setlist/the-beatles/1964/hollywood-bowl-hollywood-ca-63de4613.html",
                           "id" : "63de4613",
                           "versionId" : "7be1aaa0",
                           "eventDate" : "23-08-1964",
                           "lastUpdated" : "2013-10-20T05:18:08.000+0000"
                         }],
                         "total" : 1,
                         "page" : 1,
                         "itemsPerPage" : 20
                       }
EOD;

        $this->connection->call('artist/b10bbbfc-cf9e-42e0-be17-e2c3e1d2600d/setlists', ['p' => 1])
            ->willReturn(json_decode($rawResponse, true))
        ;

        $service = new SetlistService($this->connection->reveal());
        $result  = $service->getArtistSetlists('b10bbbfc-cf9e-42e0-be17-e2c3e1d2600d');

        static::assertNotNull($result);
    }

    public function testGetVenueSetlists(): void
    {
        $rawResponse = <<<'EOD'
                       {
                         "setlist" : [ {
                           "artist" : {
                             "mbid" : "b10bbbfc-cf9e-42e0-be17-e2c3e1d2600d",
                             "tmid" : 735610,
                             "name" : "The Beatles",
                             "sortName" : "Beatles, The",
                             "disambiguation" : "John, Paul, George and Ringo",
                             "url" : "https://www.setlist.fm/setlists/the-beatles-23d6a88b.html"
                           },
                           "venue" : {
                             "city" : { },
                             "url" : "https://www.setlist.fm/venue/compaq-center-san-jose-ca-usa-6bd6ca6e.html",
                             "id" : "6bd6ca6e",
                             "name" : "Compaq Center"
                           },
                           "tour" : {
                             "name" : "North American Tour 1964"
                           },
                           "info" : "Recorded and published as 'The Beatles at the Hollywood Bowl'",
                           "url" : "https://www.setlist.fm/setlist/the-beatles/1964/hollywood-bowl-hollywood-ca-63de4613.html",
                           "id" : "63de4613",
                           "versionId" : "7be1aaa0",
                           "eventDate" : "23-08-1964",
                           "lastUpdated" : "2013-10-20T05:18:08.000+0000"
                         }],
                         "total" : 1,
                         "page" : 1,
                         "itemsPerPage" : 20
                       }
EOD;

        $this->connection->call('venue/6bd6ca6e/setlists', ['p' => 1])
            ->willReturn(json_decode($rawResponse, true))
        ;

        $service = new SetlistService($this->connection->reveal());
        $result  = $service->getVenueSetlists('6bd6ca6e');

        static::assertNotNull($result);
    }

    public function testGetSetlistByVersion(): void
    {
        $rawResponse = <<<'EOD'
                       {
                         "artist" : {
                           "mbid" : "b10bbbfc-cf9e-42e0-be17-e2c3e1d2600d",
                           "tmid" : 735610,
                           "name" : "The Beatles",
                           "sortName" : "Beatles, The",
                           "disambiguation" : "John, Paul, George and Ringo",
                           "url" : "https://www.setlist.fm/setlists/the-beatles-23d6a88b.html"
                         },
                         "venue" : {
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
                         },
                         "tour" : {
                           "name" : "North American Tour 1964"
                         },
                         "info" : "Recorded and published as 'The Beatles at the Hollywood Bowl'",
                         "url" : "https://www.setlist.fm/setlist/the-beatles/1964/hollywood-bowl-hollywood-ca-63de4613.html",
                         "id" : "63de4613",
                         "versionId" : "7be1aaa0",
                         "eventDate" : "23-08-1964",
                         "lastUpdated" : "2013-10-20T05:18:08.000+0000"
                       }
EOD;

        $this->connection->call('setlist/version/7be1aaa0')
            ->willReturn(json_decode($rawResponse, true))
        ;

        $service = new SetlistService($this->connection->reveal());
        $result  = $service->getSetlistByVersion('7be1aaa0');

        static::assertNotNull($result);
    }

    public function testSearch(): void
    {
        $rawResponse = <<<'EOD'
                       {
                         "setlist" : [ {
                           "artist" : {
                             "mbid" : "b10bbbfc-cf9e-42e0-be17-e2c3e1d2600d",
                             "tmid" : 735610,
                             "name" : "The Beatles",
                             "sortName" : "Beatles, The",
                             "disambiguation" : "John, Paul, George and Ringo",
                             "url" : "https://www.setlist.fm/setlists/the-beatles-23d6a88b.html"
                           },
                           "venue" : {
                             "city" : { },
                             "url" : "https://www.setlist.fm/venue/compaq-center-san-jose-ca-usa-6bd6ca6e.html",
                             "id" : "6bd6ca6e",
                             "name" : "Compaq Center"
                           },
                           "tour" : {
                             "name" : "North American Tour 1964"
                           },
                           "info" : "Recorded and published as 'The Beatles at the Hollywood Bowl'",
                           "url" : "https://www.setlist.fm/setlist/the-beatles/1964/hollywood-bowl-hollywood-ca-63de4613.html",
                           "id" : "63de4613",
                           "versionId" : "7be1aaa0",
                           "eventDate" : "23-08-1964",
                           "lastUpdated" : "2013-10-20T05:18:08.000+0000"
                         }],
                         "total" : 1,
                         "page" : 1,
                         "itemsPerPage" : 20
                       }
EOD;

        $this->connection->call('search/setlists', ['p' => 1, 'artistName' => 'The Beatles'])
            ->willReturn(json_decode($rawResponse, true))
        ;

        $service = new SetlistService($this->connection->reveal());
        $result  = $service->search(SetlistSearchBuilder::create()
            ->withArtistName('The Beatles'));

        static::assertNotNull($result->getResult());
    }
}
