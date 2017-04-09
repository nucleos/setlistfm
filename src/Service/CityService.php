<?php

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
     * Get the city data for a path.
     *
     * @param string $cityId
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getCity(string $cityId): array
    {
        return $this->call('city/'.$cityId)['city'];
    }

    /**
     * Search for cities. Returns cities matches sorted by relevance.
     *
     * @param array $fields
     * @param int   $page
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function search(array $fields, int $page = 1): array
    {
        $result = $this->call('search/cities', array_merge($fields, array(
            'p' => $page,
        )))['cities'];

        // Use signular key
        $result['city'] = $result['cities'];
        unset($result['cities']);

        return $result;
    }

    /**
     * Search for countries.
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function searchCountries(): array
    {
        return $this->call('search/countries');
    }
}
