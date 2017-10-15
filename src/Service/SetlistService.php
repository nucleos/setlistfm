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

final class SetlistService extends AbstractService
{
    /**
     * Get setlist information.
     *
     * @param string $setlistId
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getSetlist(string $setlistId): array
    {
        return $this->call('setlist/'.$setlistId);
    }

    /**
     * Get setlist information by version id.
     *
     * @param string $versionId
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getSetlistByVersion(string $versionId): array
    {
        return $this->call('setlist/version/'.$versionId);
    }

    /**
     * Get artist setlists.
     *
     * @param string $mbid
     * @param int    $page
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getArtistSetlists(string $mbid, int $page = 1): array
    {
        return $this->call('artist/'.$mbid.'/setlists', array(
            'p' => $page,
        ));
    }

    /**
     * Get venue setlists.
     *
     * @param string $venueId
     * @param int    $page
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getVenueSetlists(string $venueId, int $page = 1): array
    {
        return $this->call('venue/'.$venueId.'/setlists', array(
            'p' => $page,
        ));
    }

    /**
     * Search for setlists. Returns setlists sorted by relevance.
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
        return $this->call('search/setlists', array_merge($fields, array(
            'p' => $page,
        )));
    }
}
