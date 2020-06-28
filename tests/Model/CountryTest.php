<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\SetlistFm\Tests\Model;

use Nucleos\SetlistFm\Model\Country;
use PHPUnit\Framework\TestCase;

final class CountryTest extends TestCase
{
    public function testFromApi(): void
    {
        $data = <<<'EOD'
                    {
                        "code" : "US",
                        "name" : "United States"
                    }
EOD;

        $country = Country::fromApi(json_decode($data, true));
        static::assertSame('US', $country->getCode());
        static::assertSame('United States', $country->getName());
    }
}
