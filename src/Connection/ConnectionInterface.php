<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Connection;

use Core23\SetlistFm\Exception\ApiException;
use Core23\SetlistFm\Exception\NotFoundException;

interface ConnectionInterface
{
    /**
     * Calls the API.
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function call(string $method, array $params = [], string $requestMethod = 'GET'): array;
}
