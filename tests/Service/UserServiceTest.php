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
use Nucleos\SetlistFm\Service\UserService;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;

final class UserServiceTest extends TestCase
{
    /**
     * @var ObjectProphecy<ConnectionInterface>
     */
    private $connection;

    protected function setUp(): void
    {
        $this->connection =  $this->prophesize(ConnectionInterface::class);
    }

    public function testGetUser(): void
    {
        $rawResponse = <<<'EOD'
                        {
                          "userId": "Metal-42",
                          "fullname": "Max",
                          "about": "Some dummy text",
                          "website": "http://example.com",
                          "url": "https://www.setlist.fm/user/Metal-42"
                        }
EOD;

        $this->connection->call('user/Metal-42')
            ->willReturn(json_decode($rawResponse, true))
        ;

        $service = new UserService($this->connection->reveal());
        $result  = $service->getUser('Metal-42');

        static::assertSame('Metal-42', $result->getId());
    }

    public function testGetEdits(): void
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
                          } ],
                          "total" : 1,
                          "page" : 1,
                          "itemsPerPage" : 20
                        }
EOD;

        $this->connection->call('user/42/edited', ['p' => 1])
            ->willReturn(json_decode($rawResponse, true))
        ;

        $service = new UserService($this->connection->reveal());
        $result  = $service->getEdits('42');

        static::assertCount(1, $result);
    }

    public function testGetAttends(): void
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

        $this->connection->call('user/42/attended', ['p' => 1])
            ->willReturn(json_decode($rawResponse, true))
        ;

        $service = new UserService($this->connection->reveal());
        $result  = $service->getAttends('42');

        static::assertCount(1, $result);
    }
}
