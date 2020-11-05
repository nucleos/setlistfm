<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\SetlistFm\Service;

use Nucleos\SetlistFm\Builder\ArtistSearchBuilder;
use Nucleos\SetlistFm\Connection\ConnectionInterface;
use Nucleos\SetlistFm\Exception\ApiException;
use Nucleos\SetlistFm\Exception\NotFoundException;
use Nucleos\SetlistFm\Model\Artist;
use Nucleos\SetlistFm\Model\ArtistSearchResult;

final class ArtistService
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
     * Get the metadata for an artist.
     *
     * @throws ApiException
     * @throws NotFoundException
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
     * @throws ApiException
     * @throws NotFoundException
     */
    public function search(ArtistSearchBuilder $builder): ArtistSearchResult
    {
        $response = $this->connection->call('search/artists', $builder->getQuery());

        if (!isset($response['artist'])) {
            return ArtistSearchResult::createEmpty();
        }

        return ArtistSearchResult::fromApi($response);
    }
}
