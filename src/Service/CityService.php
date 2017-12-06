<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Service;

use Core23\SetlistFm\Exception\ApiException;
use Core23\SetlistFm\Exception\NotFoundException;

final class CityService extends AbstractService
{
    /**
     * Get the city data for an id.
     *
     * @param string $cityId
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return array
     */
    public function getCity(string $cityId): array
    {
        return $this->call('city/'.$cityId);
    }

    /**
     * Search for cities. Returns cities sorted by relevance.
     *
     * @param array $fields
     * @param int   $page
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return array
     */
    public function search(array $fields, int $page = 1): array
    {
        return $this->call('search/cities', array_merge($fields, [
            'p' => $page,
        ]));
    }

    /**
     * Search for countries.
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return array
     */
    public function searchCountries(): array
    {
        return $this->call('search/countries');
    }
}
