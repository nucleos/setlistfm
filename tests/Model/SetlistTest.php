<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Tests\Model;

use Core23\SetlistFm\Model\Setlist;
use DateTime;
use PHPUnit\Framework\TestCase;

final class SetlistTest extends TestCase
{
    public function testFromApi(): void
    {
        $data = <<<'EOD'
            {
               "id" : "63de4613",
               "versionId" : "7be1aaa0",
               "eventDate" : "23-08-1964",
               "lastUpdated" : "2013-10-20T05:18:08.000+0000",
               "artist" : {
                  "mbid" : "b10bbbfc-cf9e-42e0-be17-e2c3e1d2600d",
                  "tmid" : 735610,
                  "name" : "The Beatles",
                  "sortName" : "Beatles, The",
                  "disambiguation" : "",
                  "url" : "https://www.setlist.fm/setlists/the-beatles-23d6a88b.html"
               },
               "venue" : {
                  "id" : "33d62cf9",
                  "name" : "Hollywood Bowl",
                  "city" : {
                     "id" : "5368361",
                     "name" : "Los Angeles",
                     "state" : "California",
                     "stateCode" : "CA",
                     "coords" : {
                        "lat" : 34.052,
                        "long" : -118.244
                     },
                     "country" : {
                        "code" : "US",
                        "name" : "United States"
                     }
                  },
                  "url" : "https://www.setlist.fm/venue/hollywood-bowl-los-angeles-ca-usa-33d62cf9.html"
               },
               "tour" : {
                  "name" : "North American Tour 1964"
               },
               "sets" : {
                  "set" : [ {
                     "song" : [ {
                        "name" : "Twist and Shout",
                        "cover" : {
                           "mbid" : "f18eac60-48d2-4d2b-b432-e43ce7e31d36",
                           "name" : "The Top Notes",
                           "sortName" : "Top Notes, The",
                           "url" : "https://www.setlist.fm/setlists/the-top-notes-53d433dd.html"
                        }
                     }, {
                        "name" : "You Can't Do That"
                     }, {
                        "name" : "All My Loving"
                     }, {
                        "name" : "She Loves You"
                     }, {
                        "name" : "Things We Said Today"
                     }, {
                        "name" : "Roll Over Beethoven",
                        "cover" : {
                           "mbid" : "592a3b6d-c42b-4567-99c9-ecf63bd66499",
                           "tmid" : 734540,
                           "name" : "Chuck Berry",
                           "sortName" : "Berry, Chuck",
                           "disambiguation" : "",
                           "url" : "https://www.setlist.fm/setlists/chuck-berry-63d6a2b7.html"
                        }
                     }, {
                        "name" : "Can't Buy Me Love"
                     }, {
                        "name" : "If I Fell"
                     }, {
                        "name" : "I Want to Hold Your Hand"
                     }, {
                        "name" : "Boys",
                        "cover" : {
                           "mbid" : "a8540ea0-1a74-4c22-8b70-1348a77a74a0",
                           "name" : "The Shirelles",
                           "sortName" : "Shirelles, The",
                           "disambiguation" : "",
                           "url" : "https://www.setlist.fm/setlists/the-shirelles-bd69d7a.html"
                        }
                     }, {
                        "name" : "A Hard Day's Night"
                     }, {
                        "name" : "Long Tall Sally",
                        "cover" : {
                           "mbid" : "95c2339b-8277-49a6-9aaf-08d8eeeaa0be",
                           "tmid" : 735520,
                           "name" : "Little Richard",
                           "sortName" : "Little Richard",
                           "disambiguation" : "",
                           "url" : "https://www.setlist.fm/setlists/little-richard-4bd6af2e.html"
                        }
                     } ]
                  } ]
               },
               "info" : "Recorded and published as 'The Beatles at the Hollywood Bowl'",
               "url" : "https://www.setlist.fm/setlist/the-beatles/1964/hollywood-bowl-los-angeles-ca-63de4613.html"
            }
EOD;

        $setlist = Setlist::fromApi(json_decode($data, true));
        static::assertSame('63de4613', $setlist->getId());
        static::assertSame('7be1aaa0', $setlist->getVersionId());
        static::assertNotNull($setlist->getVenue());
        static::assertNotNull($setlist->getArtist());
        static::assertEquals(new DateTime('23-08-1964'), $setlist->getEventDate(), '', 0);
        static::assertSame('Recorded and published as \'The Beatles at the Hollywood Bowl\'', $setlist->getInfo());
        static::assertCount(1, $setlist->getSets());
        static::assertNotNull($setlist->getTour());
        static::assertEquals(new DateTime('2013-10-20T05:18:08.000+0000'), $setlist->getUpdateDate(), '', 0);
        static::assertSame('https://www.setlist.fm/setlist/the-beatles/1964/hollywood-bowl-los-angeles-ca-63de4613.html', $setlist->getUrl());
    }

    public function testFromApiWithSingleSet(): void
    {
        $data = <<<'EOD'
            {
               "id" : "63de4613",
               "versionId" : "7be1aaa0",
               "eventDate" : "23-08-1964",
               "lastUpdated" : "2013-10-20T05:18:08.000+0000",
               "artist" : {
                  "mbid" : "b10bbbfc-cf9e-42e0-be17-e2c3e1d2600d",
                  "tmid" : 735610,
                  "name" : "The Beatles",
                  "sortName" : "Beatles, The",
                  "disambiguation" : "",
                  "url" : "https://www.setlist.fm/setlists/the-beatles-23d6a88b.html"
               },
               "venue" : {
                  "id" : "33d62cf9",
                  "name" : "Hollywood Bowl",
                  "city" : {
                     "id" : "5368361",
                     "name" : "Los Angeles",
                     "state" : "California",
                     "stateCode" : "CA",
                     "coords" : {
                        "lat" : 34.052,
                        "long" : -118.244
                     },
                     "country" : {
                        "code" : "US",
                        "name" : "United States"
                     }
                  },
                  "url" : "https://www.setlist.fm/venue/hollywood-bowl-los-angeles-ca-usa-33d62cf9.html"
               },
               "tour" : {
                  "name" : "North American Tour 1964"
               },
               "set" : [ {
                  "song" : [ {
                     "name" : "Twist and Shout",
                     "cover" : {
                        "mbid" : "f18eac60-48d2-4d2b-b432-e43ce7e31d36",
                        "name" : "The Top Notes",
                        "sortName" : "Top Notes, The",
                        "url" : "https://www.setlist.fm/setlists/the-top-notes-53d433dd.html"
                     }
                  }, {
                     "name" : "You Can't Do That"
                  }, {
                     "name" : "All My Loving"
                  }, {
                     "name" : "She Loves You"
                  }, {
                     "name" : "Things We Said Today"
                  }, {
                     "name" : "Roll Over Beethoven",
                     "cover" : {
                        "mbid" : "592a3b6d-c42b-4567-99c9-ecf63bd66499",
                        "tmid" : 734540,
                        "name" : "Chuck Berry",
                        "sortName" : "Berry, Chuck",
                        "disambiguation" : "",
                        "url" : "https://www.setlist.fm/setlists/chuck-berry-63d6a2b7.html"
                     }
                  }, {
                     "name" : "Can't Buy Me Love"
                  }, {
                     "name" : "If I Fell"
                  }, {
                     "name" : "I Want to Hold Your Hand"
                  }, {
                     "name" : "Boys",
                     "cover" : {
                        "mbid" : "a8540ea0-1a74-4c22-8b70-1348a77a74a0",
                        "name" : "The Shirelles",
                        "sortName" : "Shirelles, The",
                        "disambiguation" : "",
                        "url" : "https://www.setlist.fm/setlists/the-shirelles-bd69d7a.html"
                     }
                  }, {
                     "name" : "A Hard Day's Night"
                  }, {
                     "name" : "Long Tall Sally",
                     "cover" : {
                        "mbid" : "95c2339b-8277-49a6-9aaf-08d8eeeaa0be",
                        "tmid" : 735520,
                        "name" : "Little Richard",
                        "sortName" : "Little Richard",
                        "disambiguation" : "",
                        "url" : "https://www.setlist.fm/setlists/little-richard-4bd6af2e.html"
                     }
                  } ]
               } ],
               "info" : "Recorded and published as 'The Beatles at the Hollywood Bowl'",
               "url" : "https://www.setlist.fm/setlist/the-beatles/1964/hollywood-bowl-los-angeles-ca-63de4613.html"
            }
EOD;

        $setlist = Setlist::fromApi(json_decode($data, true));
        static::assertSame('63de4613', $setlist->getId());
        static::assertSame('7be1aaa0', $setlist->getVersionId());
        static::assertNotNull($setlist->getVenue());
        static::assertNotNull($setlist->getArtist());
        static::assertEquals(new DateTime('23-08-1964'), $setlist->getEventDate(), '', 0);
        static::assertSame('Recorded and published as \'The Beatles at the Hollywood Bowl\'', $setlist->getInfo());
        static::assertCount(1, $setlist->getSets());
        static::assertNotNull($setlist->getTour());
        static::assertEquals(new DateTime('2013-10-20T05:18:08.000+0000'), $setlist->getUpdateDate(), '', 0);
        static::assertSame('https://www.setlist.fm/setlist/the-beatles/1964/hollywood-bowl-los-angeles-ca-63de4613.html', $setlist->getUrl());
    }
}
