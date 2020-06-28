<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\SetlistFm\Service;

use Nucleos\SetlistFm\Builder\CitySearchBuilder;
use Nucleos\SetlistFm\Connection\ConnectionInterface;
use Nucleos\SetlistFm\Exception\ApiException;
use Nucleos\SetlistFm\Exception\NotFoundException;
use Nucleos\SetlistFm\Model\City;
use Nucleos\SetlistFm\Model\CitySearchResult;

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
