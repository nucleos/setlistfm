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

final class VenueService extends AbstractService
{
    /**
     * Get the metadata for an artist.
     *
     * @param string $venueId
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getVenue(string $venueId): array
    {
        return $this->call('venue/'.$venueId);
    }

    /**
     * Search for artists. Returns artists matches sorted by relevance.
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
        return $this->call('search/venues', array_merge($fields, array(
            'p' => $page,
        )))['venue'];
    }
}
