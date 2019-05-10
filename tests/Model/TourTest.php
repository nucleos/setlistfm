<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Tests\Model;

use Core23\SetlistFm\Model\Tour;
use PHPUnit\Framework\TestCase;

class TourTest extends TestCase
{
    public function testFromApi(): void
    {
        $data = <<<'EOD'
                    {
                        "name" : "North American Tour 1964"
                    }
EOD;

        $tour = Tour::fromApi(json_decode($data, true));
        static::assertSame('North American Tour 1964', $tour->getName());
    }
}
