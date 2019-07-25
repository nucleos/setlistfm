<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Service;

use Core23\SetlistFm\Builder\CitySearchBuilder;
use Core23\SetlistFm\Connection\ConnectionInterface;
use Core23\SetlistFm\Exception\ApiException;
use Core23\SetlistFm\Exception\NotFoundException;
use Core23\SetlistFm\Model\City;
use Core23\SetlistFm\Model\CitySearchResult;

final class CityService
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
     * Get the city data for an id.
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getCity(int $cityId): City
    {
        return City::fromApi(
            $this->connection->call('city/'.$cityId)
        );
    }

    /**
     * Search for cities.
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function search(CitySearchBuilder $builder): CitySearchResult
    {
        $response = $this->connection->call('search/cities', $builder->getQuery());

        if (!\array_key_exists('cities', $response)) {
            return CitySearchResult::createEmpty();
        }

        return CitySearchResult::fromApi($response);
    }
}
