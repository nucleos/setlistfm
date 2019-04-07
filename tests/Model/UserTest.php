<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Tests\Model;

use Core23\SetlistFm\Model\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testFromApi(): void
    {
        $apiData = json_decode(
            <<<'EOD'
                    {
                      "userId": "Metal-42",
                      "fullname": "Max",
                      "about": "Some dummy text",
                      "website": "http://example.com",
                      "url": "https://www.setlist.fm/user/Metal-42"
                    }
            EOD
        ,
            true
        );

        $user = User::fromApi($apiData);
        $this->assertSame('Metal-42', $user->getId());
        $this->assertSame('Some dummy text', $user->getAbout());
        $this->assertSame('Max', $user->getFullname());
        $this->assertSame('http://example.com', $user->getWebsite());
        $this->assertSame('https://www.setlist.fm/user/Metal-42', $user->getUrl());
    }
}
