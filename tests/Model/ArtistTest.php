<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Tests\Model;

use Core23\SetlistFm\Model\Artist;
use PHPUnit\Framework\TestCase;

class ArtistTest extends TestCase
{
    public function testFromApi(): void
    {
        $data = <<<'EOD'
                {
                  "mbid" : "b10bbbfc-cf9e-42e0-be17-e2c3e1d2600d",
                  "tmid" : 735610,
                  "name" : "The Beatles",
                  "sortName" : "Beatles, The",
                  "disambiguation" : "John, Paul, George and Ringo",
                  "url" : "https://www.setlist.fm/setlists/the-beatles-23d6a88b.html"
                }
EOD;

        $artist = Artist::fromApi(json_decode($data, true));
        $this->assertSame('The Beatles', $artist->getName());
        $this->assertSame('Beatles, The', $artist->getSortName());
        $this->assertSame('John, Paul, George and Ringo', $artist->getDisambiguation());
        $this->assertSame('b10bbbfc-cf9e-42e0-be17-e2c3e1d2600d', $artist->getMbid());
        $this->assertSame(735610, $artist->getTmid());
        $this->assertSame('https://www.setlist.fm/setlists/the-beatles-23d6a88b.html', $artist->getUrl());
    }
}
