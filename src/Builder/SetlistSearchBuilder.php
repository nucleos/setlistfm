<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\SetlistFm\Builder;

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

    public static function create(): self
    {
        return new static();
    }

    public function page(int $page): self
    {
        $this->query['p'] = $page;

        return $this;
    }

    public function withArtistName(string $name): self
    {
        $this->query['artistName'] = $name;

        return $this;
    }

    public function withArtistMbid(string $mbid): self
    {
        $this->query['artistMbid'] = $mbid;

        return $this;
    }

    public function withArtistTmbid(int $tmid): self
    {
        $this->query['artistTmbid'] = $tmid;

        return $this;
    }

    public function withCity(string $name): self
    {
        $this->query['cityName'] = $name;

        return $this;
    }

    public function withCityId(int $id): self
    {
        $this->query['cityId'] = $id;

        return $this;
    }

    public function withCountryCode(string $code): self
    {
        $this->query['countryCode'] = $code;

        return $this;
    }

    public function withDate(DateTime $date): self
    {
        $this->query['date'] = $date->format('d-m-Y');

        return $this;
    }

    public function withYear(int $year): self
    {
        $this->query['year'] = $year;

        return $this;
    }

    public function withLastUpdated(DateTime $date): self
    {
        $this->query['lastUpdated'] = $date->format('YmdHis');

        return $this;
    }

    public function withState(string $name): self
    {
        $this->query['state'] = $name;

        return $this;
    }

    public function withStateCode(string $code): self
    {
        $this->query['stateCode'] = $code;

        return $this;
    }

    public function withTourName(string $name): self
    {
        $this->query['tourName'] = $name;

        return $this;
    }

    public function withVenueName(string $name): self
    {
        $this->query['venueName'] = $name;

        return $this;
    }

    public function withVenueId(string $venueId): self
    {
        $this->query['venueId'] = $venueId;

        return $this;
    }

    public function getQuery(): array
    {
        return $this->query;
    }
}
