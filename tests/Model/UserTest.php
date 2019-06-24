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

final class UserTest extends TestCase
{
    public function testFromApi(): void
    {
        $data = <<<'EOD'
                    {
                      "userId": "Metal-42",
                      "fullname": "Max",
                      "about": "Some dummy text",
                      "website": "http://example.com",
                      "url": "https://www.setlist.fm/user/Metal-42"
                    }
EOD;

        $user = User::fromApi(json_decode($data, true));
        static::assertSame('Metal-42', $user->getId());
        static::assertSame('Some dummy text', $user->getAbout());
        static::assertSame('Max', $user->getFullname());
        static::assertSame('http://example.com', $user->getWebsite());
        static::assertSame('https://www.setlist.fm/user/Metal-42', $user->getUrl());
    }
}
