<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Tests\Bridge\Symfony\DependencyInjection;

use Core23\SetlistFm\Bridge\Symfony\DependencyInjection\Core23SetlistFmExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

class Core23SetlistFmExtensionTest extends AbstractExtensionTestCase
{
    public function testLoadDefault(): void
    {
        $this->load([
            'api' => [
                'key' => '0815',
            ],
        ]);

        $this->assertContainerBuilderHasParameter('core23.setlistfm.api.endpoint', 'https://api.setlist.fm/rest/1.0/');
        $this->assertContainerBuilderHasParameter('core23.setlistfm.api.key', '0815');

        $this->assertContainerBuilderHasAlias('core23.setlistfm.http.client', 'httplug.client.default');
        $this->assertContainerBuilderHasAlias('core23.setlistfm.http.message_factory', 'httplug.message_factory.default');
    }

    protected function getContainerExtensions(): array
    {
        return [
            new Core23SetlistFmExtension(),
        ];
    }
}
