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

final class SetlistService extends AbstractService
{
    /**
     * Get setlist information.
     *
     * @param string $setlistId
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return array
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
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return array
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
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return array
     */
    public function getArtistSetlists(string $mbid, int $page = 1): array
    {
        return $this->call('artist/'.$mbid.'/setlists', [
            'p' => $page,
        ]);
    }

    /**
     * Get venue setlists.
     *
     * @param string $venueId
     * @param int    $page
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return array
     */
    public function getVenueSetlists(string $venueId, int $page = 1): array
    {
        return $this->call('venue/'.$venueId.'/setlists', [
            'p' => $page,
        ]);
    }

    /**
     * Search for setlists. Returns setlists sorted by relevance.
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
        return $this->call('search/setlists', array_merge($fields, [
            'p' => $page,
        ]));
    }
}
