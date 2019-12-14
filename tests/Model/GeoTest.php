<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Tests\Model;

use Core23\SetlistFm\Model\Geo;
use PHPUnit\Framework\TestCase;

final class GeoTest extends TestCase
{
    public function testFromApi(): void
    {
        $data = <<<'EOD'
                    {
                        "long" : -118.3267434,
                        "lat" : 34.0983425
                    }
EOD;

        $geo = Geo::fromApi(json_decode($data, true));
        static::assertSame(34.0983425, $geo->getLatitude());
        static::assertSame(-118.3267434, $geo->getLongitude());
    }
}
