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
use Core23\SetlistFm\Model\Setlist;

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
     * @return Setlist
     */
    public function getSetlist(string $setlistId): Setlist
    {
        return Setlist::fromApi(
            $this->call('setlist/'.$setlistId)
        );
    }

    /**
     * Get setlist information by version id.
     *
     * @param string $versionId
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return Setlist
     */
    public function getSetlistByVersion(string $versionId): Setlist
    {
        return Setlist::fromApi(
            $this->call('setlist/version/'.$versionId)
        );
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
     * @return Setlist[]
     */
    public function getArtistSetlists(string $mbid, int $page = 1): array
    {
        $response = $this->call('artist/'.$mbid.'/setlists', [
            'p' => $page,
        ]);

        if (!array_key_exists('setlist', $response)) {
            return [];
        }

        return array_map(function ($data) {
            return Setlist::fromApi($data);
        }, $response['setlist']);
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
     * @return Setlist[]
     */
    public function getVenueSetlists(string $venueId, int $page = 1): array
    {
        $response =  $this->call('venue/'.$venueId.'/setlists', [
            'p' => $page,
        ]);

        if (!array_key_exists('setlist', $response)) {
            return [];
        }

        return array_map(function ($data) {
            return Setlist::fromApi($data);
        }, $response['setlist']);
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
     * @return Setlist[]
     */
    public function search(array $fields, int $page = 1): array
    {
        $response=  $this->call('search/setlists', array_merge($fields, [
            'p' => $page,
        ]));

        if (!array_key_exists('setlist', $response)) {
            return [];
        }

        return array_map(function ($data) {
            return Setlist::fromApi($data);
        }, $response['setlist']);
    }
}
