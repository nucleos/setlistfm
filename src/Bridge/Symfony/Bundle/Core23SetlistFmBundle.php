<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Bridge\Symfony\Bundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

final class Core23SetlistFmBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    protected function getContainerExtensionClass()
    {
        return 'Core23\SetlistFm\Bridge\Symfony\DependencyInjection\Core23SetlistFmExtension';
    }
}
