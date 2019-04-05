<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Builder;

use DateTime;

final class SetlistSearchBuilder
{
    /**
     * @var array
     */
    private $query;

    private function __construct()
    {
        $this->query = [];

        $this->page(1);
    }

    /**
     * @param int $page
     *
     * @return SetlistSearchBuilder
     */
    public function page(int $page): self
    {
        $this->query['p'] = $page;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return SetlistSearchBuilder
     */
    public function withArtistName(string $name): self
    {
        $this->query['artistName'] = $name;

        return $this;
    }

    /**
     * @param string $mbid
     *
     * @return SetlistSearchBuilder
     */
    public function withArtistMbid(string $mbid): self
    {
        $this->query['artistMbid'] = $mbid;

        return $this;
    }

    /**
     * @param int $tmid
     *
     * @return SetlistSearchBuilder
     */
    public function withArtistTmbid(int $tmid): self
    {
        $this->query['artistTmbid'] = $tmid;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return SetlistSearchBuilder
     */
    public function withCity(string $name): self
    {
        $this->query['cityName'] = $name;

        return $this;
    }

    /**
     * @param int $id
     *
     * @return SetlistSearchBuilder
     */
    public function withCityId(int $id): self
    {
        $this->query['cityId'] = $id;

        return $this;
    }

    /**
     * @param string $code
     *
     * @return SetlistSearchBuilder
     */
    public function withCountryCode(string $code): self
    {
        $this->query['countryCode'] = $code;

        return $this;
    }

    /**
     * @param DateTime $date
     *
     * @return SetlistSearchBuilder
     */
    public function withDate(DateTime $date): self
    {
        $this->query['date'] = $date->format('d-m-Y');

        return $this;
    }

    /**
     * @param int $year
     *
     * @return SetlistSearchBuilder
     */
    public function withYear(int $year): self
    {
        $this->query['year'] = $year;

        return $this;
    }

    /**
     * @param string $eventId
     *
     * @return SetlistSearchBuilder
     *
     * @deprecated since setlist.fm API 1.0
     */
    public function withLastFm(string $eventId): self
    {
        $this->query['lastFm'] = $eventId;

        return $this;
    }

    /**
     * @param DateTime $date
     *
     * @return SetlistSearchBuilder
     */
    public function withLastUpdated(DateTime $date): self
    {
        $this->query['lastUpdated'] = $date->format('YmdHHmmss');

        return $this;
    }

    /**
     * @param string $name
     *
     * @return SetlistSearchBuilder
     */
    public function withState(string $name): self
    {
        $this->query['state'] = $name;

        return $this;
    }

    /**
     * @param string $code
     *
     * @return SetlistSearchBuilder
     */
    public function withStateCode(string $code): self
    {
        $this->query['stateCode'] = $code;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return SetlistSearchBuilder
     */
    public function withTourName(string $name): self
    {
        $this->query['tourName'] = $name;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return SetlistSearchBuilder
     */
    public function withVenueName(string $name): self
    {
        $this->query['venueName'] = $name;

        return $this;
    }

    /**
     * @param string $venueId
     *
     * @return SetlistSearchBuilder
     */
    public function withVenueId(string $venueId): self
    {
        $this->query['venueId'] = $venueId;

        return $this;
    }

    /**
     * @return array
     */
    public function getQuery(): array
    {
        return $this->query;
    }
}
