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
        $apiData = json_decode(
            <<<'EOD'
                    {
                        "name" : "North American Tour 1964"
                    }
            EOD
        ,
            true
        );

        $tour = Tour::fromApi($apiData);
        $this->assertSame('North American Tour 1964', $tour->getName());
    }
}
