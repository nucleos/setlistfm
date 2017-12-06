<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Service;

use Core23\SetlistFm\Connection\ConnectionInterface;
use Core23\SetlistFm\Exception\ApiException;
use Core23\SetlistFm\Exception\NotFoundException;

abstract class AbstractService
{
    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * AbstractService constructor.
     *
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Calls the API unsigned.
     *
     * @param string $method
     * @param array  $params
     * @param string $requestMethod
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return array
     */
    final protected function call(string $method, array $params = [], $requestMethod = 'GET'): array
    {
        foreach ($params as $key => $value) {
            if ($value instanceof \DateTime) {
                $params[$key] = $this->toDateString($value);
            }
        }

        return $this->connection->call($method, $params, $requestMethod);
    }

    /**
     * Formats a date to a timestamp.
     *
     * @param \DateTime|null $date
     *
     * @return string|null
     */
    private function toDateString(\DateTime $date = null): ?string
    {
        if (null === $date) {
            return null;
        }

        return $date->format('d-m-Y');
    }
}
