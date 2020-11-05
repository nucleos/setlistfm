<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\SetlistFm\Service;

use Nucleos\SetlistFm\Connection\ConnectionInterface;
use Nucleos\SetlistFm\Exception\ApiException;
use Nucleos\SetlistFm\Exception\NotFoundException;
use Nucleos\SetlistFm\Model\CountrySearchResult;

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

        if (!isset($response['country'])) {
            return CountrySearchResult::createEmpty();
        }

        return CountrySearchResult::fromApi($response);
    }
}
