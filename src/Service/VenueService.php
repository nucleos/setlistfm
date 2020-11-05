<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\SetlistFm\Service;

use Nucleos\SetlistFm\Builder\VenueSearchBuilder;
use Nucleos\SetlistFm\Connection\ConnectionInterface;
use Nucleos\SetlistFm\Exception\ApiException;
use Nucleos\SetlistFm\Exception\NotFoundException;
use Nucleos\SetlistFm\Model\Venue;
use Nucleos\SetlistFm\Model\VenueSearchResult;

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

        if (!isset($response['venue'])) {
            return VenueSearchResult::createEmpty();
        }

        return VenueSearchResult::fromApi($response);
    }
}
