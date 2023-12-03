<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\SetlistFm\Tests\Model;

use Nucleos\SetlistFm\Model\Tour;
use PHPUnit\Framework\TestCase;

final class TourTest extends TestCase
{
    public function testFromApi(): void
    {
        $data = <<<'EOD'
                    {
                        "name" : "North American Tour 1964"
                    }
EOD;

        $tour = Tour::fromApi(json_decode($data, true));
        self::assertSame('North American Tour 1964', $tour->getName());
    }
}
