<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Service;

use Core23\SetlistFm\Builder\VenueSearchBuilder;
use Core23\SetlistFm\Connection\ConnectionInterface;
use Core23\SetlistFm\Exception\ApiException;
use Core23\SetlistFm\Exception\NotFoundException;
use Core23\SetlistFm\Model\Venue;
use Core23\SetlistFm\Model\VenueSearchResult;

final class VenueService
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
    public function getVenue(string $venueId): Venue
    {
        return Venue::fromApi(
            $this->connection->call('venue/'.$venueId)
        );
    }

    /**
     * Search for venues.
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function search(VenueSearchBuilder $builder): VenueSearchResult
    {
        $response = $this->connection->call('search/venues', $builder->getQuery());

        if (!\array_key_exists('venue', $response)) {
            return VenueSearchResult::createEmpty();
        }

        return VenueSearchResult::fromApi($response);
    }
}
