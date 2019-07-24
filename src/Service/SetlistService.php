<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Service;

use Core23\SetlistFm\Builder\SetlistSearchBuilder;
use Core23\SetlistFm\Connection\ConnectionInterface;
use Core23\SetlistFm\Exception\ApiException;
use Core23\SetlistFm\Exception\NotFoundException;
use Core23\SetlistFm\Model\Setlist;
use Core23\SetlistFm\Model\SetlistSearchResult;

final class SetlistService
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
     * Get setlist information.
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getSetlist(string $setlistId): Setlist
    {
        return Setlist::fromApi(
            $this->connection->call('setlist/'.$setlistId)
        );
    }

    /**
     * Get setlist information by version id.
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getSetlistByVersion(string $versionId): Setlist
    {
        return Setlist::fromApi(
            $this->connection->call('setlist/version/'.$versionId)
        );
    }

    /**
     * Get artist setlists.
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return Setlist[]
     */
    public function getArtistSetlists(string $mbid, int $page = 1): array
    {
        $response = $this->connection->call('artist/'.$mbid.'/setlists', [
            'p' => $page,
        ]);

        if (!\array_key_exists('setlist', $response)) {
            return [];
        }

        return array_map(static function ($data) {
            return Setlist::fromApi($data);
        }, $response['setlist']);
    }

    /**
     * Get venue setlists.
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return Setlist[]
     */
    public function getVenueSetlists(string $venueId, int $page = 1): array
    {
        $response =  $this->connection->call('venue/'.$venueId.'/setlists', [
            'p' => $page,
        ]);

        if (!\array_key_exists('setlist', $response)) {
            return [];
        }

        return array_map(static function ($data) {
            return Setlist::fromApi($data);
        }, $response['setlist']);
    }

    /**
     * Search for setlists.
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function search(SetlistSearchBuilder $builder): SetlistSearchResult
    {
        $response=  $this->connection->call('search/setlists', $builder->getQuery());

        if (!\array_key_exists('setlist', $response)) {
            return SetlistSearchResult::createEmpty();
        }

        return SetlistSearchResult::fromApi($response);
    }
}
