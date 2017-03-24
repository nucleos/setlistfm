<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Service;

use Core23\SetlistFm\Connection\ConnectionInterface;
use Core23\SetlistFm\Connection\SessionInterface;
use Core23\SetlistFm\Exception\ApiException;
use Core23\SetlistFm\Exception\NotFoundException;

abstract class AbstractService
{
    /**
     * @var ConnectionInterface
     */
    protected $connection;

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
     * Formats a date to a timestamp.
     *
     * @param \DateTime|null $date
     *
     * @return int|null
     */
    final protected function toTimestamp(\DateTime $date = null)
    {
        if (null === $date) {
            return null;
        }

        return $date->getTimestamp();
    }

    /**
     * Calls the API unsigned.
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
    final protected function call($method, array $params = array(), $requestMethod = 'GET') : array
    {
        try {
            $response = $this->connection->call($method, $params, $requestMethod);
            return $this->cleanResponseData($response);
        } catch (ApiException $e) {
            if ($e->getCode() == 404) {
                throw new NotFoundException('No entity was found for your request.', $e->getCode(), $e);
            }
            throw $e;
        }
    }

    /**
     * Clean response keys and remove @ sign
     *
     * @param array $array
     *
     * @return array
     */
    private function cleanResponseData(array $array)
    {
        $result = array();

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = $this->cleanResponseData($value);
            }

            $key = str_replace('@', '', $key);
            $result[$key] = $value;
        }

        return $result;
    }
}
