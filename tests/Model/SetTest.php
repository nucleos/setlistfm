<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Tests\Model;

use Core23\SetlistFm\Model\Set;
use PHPUnit\Framework\TestCase;

final class SetTest extends TestCase
{
    public function testFromApi(): void
    {
        $data = <<<'EOD'
                  	{
                  	 "name": "First set",
                  	 "encore": 3,
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
                  }
EOD;

        $set = Set::fromApi(json_decode($data, true));
        static::assertSame('First set', $set->getName());
        static::assertCount(12, $set->getSongs());
        static::assertSame(3, $set->getEncore());
    }
}
