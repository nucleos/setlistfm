<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\SetlistFm\Tests\Model;

use Nucleos\SetlistFm\Model\Artist;
use PHPUnit\Framework\TestCase;

final class ArtistTest extends TestCase
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
        self::assertSame('The Beatles', $artist->getName());
        self::assertSame('Beatles, The', $artist->getSortName());
        self::assertSame('John, Paul, George and Ringo', $artist->getDisambiguation());
        self::assertSame('b10bbbfc-cf9e-42e0-be17-e2c3e1d2600d', $artist->getMbid());
        self::assertSame(735610, $artist->getTmid());
        self::assertSame('https://www.setlist.fm/setlists/the-beatles-23d6a88b.html', $artist->getUrl());
    }
}
