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
use Core23\SetlistFm\Model\CountrySearchResult;

final class CountryService
{
    /**
     * @var ConnectionInterface
     */
    private $connection;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Search for countries.
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function search(): CountrySearchResult
    {
        $response = $this->connection->call('search/countries');

        if (!\array_key_exists('country', $response)) {
            return CountrySearchResult::createEmpty();
        }

        return CountrySearchResult::fromApi($response);
    }
}
