<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Service;

use Core23\SetlistFm\Builder\ArtistSearchBuilder;
use Core23\SetlistFm\Connection\ConnectionInterface;
use Core23\SetlistFm\Exception\ApiException;
use Core23\SetlistFm\Exception\NotFoundException;
use Core23\SetlistFm\Model\Artist;

final class ArtistService
{
    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Get the metadata for an artist.
     *
     * @param string $mbid
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return Artist
     */
    public function getArtist(string $mbid): Artist
    {
        return Artist::fromApi(
            $this->connection->call('artist/'.$mbid)
        );
    }

    /**
     * Search for artists.
     *
     * @param ArtistSearchBuilder $builder
     *
     * @return Artist[]
     */
    public function search(ArtistSearchBuilder $builder): array
    {
        $response = $this->connection->call('search/artists', $builder->getQuery());

        if (!\array_key_exists('artist', $response)) {
            return [];
        }

        return array_map(static function ($data) {
            return Artist::fromApi($data);
        }, $response['artist']);
    }
}
