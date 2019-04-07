<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Tests\Model;

use Core23\SetlistFm\Model\Country;
use PHPUnit\Framework\TestCase;

class CountryTest extends TestCase
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
        $this->assertSame('US', $country->getCode());
        $this->assertSame('United States', $country->getName());
    }
}
