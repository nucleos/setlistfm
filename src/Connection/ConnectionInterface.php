<?php

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
     * @param string $method
     * @param array  $params
     * @param string $requestMethod
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function call(string $method, array $params = array(), string $requestMethod = 'GET'): array;
}
