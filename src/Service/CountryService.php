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
use Core23\SetlistFm\Model\Country;

final class CountryService extends AbstractService
{
    /**
     * Search for countries.
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return Country[]
     */
    public function search(): array
    {
        $response = $this->call('search/countries');

        if (!\array_key_exists('country', $response)) {
            return [];
        }

        return array_map(function ($data) {
            return Country::fromApi($data);
        }, $response['country']);
    }
}
