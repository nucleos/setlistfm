<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Tests\Model;

use Core23\SetlistFm\Model\City;
use PHPUnit\Framework\TestCase;

class CityTest extends TestCase
{
    public function testFromApi(): void
    {
        $data = <<<'EOD'
                    {
                      "id" : "5357527",
                      "name" : "Hollywood",
                      "stateCode" : "CA",
                      "state" : "California",
                      "coords" : {
                        "long" : -118.3267434,
                        "lat" : 34.0983425
                      },
                      "country" : {
                        "code" : "US",
                        "name" : "United States"
                      }
                    }
EOD;

        $city = City::fromApi(json_decode($data, true));
        $this->assertSame(5357527, $city->getId());
        $this->assertSame('Hollywood', $city->getName());
        $this->assertSame('California', $city->getState());
        $this->assertNotNull($city->getCountry());
        $this->assertNotNull($city->getGeo());
        $this->assertSame('CA', $city->getStateCode());
    }
}
