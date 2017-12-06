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

final class VenueService extends AbstractService
{
    /**
     * Get the metadata for an artist.
     *
     * @param string $venueId
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return array
     */
    public function getVenue(string $venueId): array
    {
        return $this->call('venue/'.$venueId);
    }

    /**
     * Search for venues. Returns venues sorted by relevance.
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
        return $this->call('search/venues', array_merge($fields, [
            'p' => $page,
        ]));
    }
}
