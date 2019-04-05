<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Builder;

final class VenueSearchBuilder
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
     * @return VenueSearchBuilder
     */
    public static function create(): self
    {
        return new static();
    }

    /**
     * @param int $page
     *
     * @return VenueSearchBuilder
     */
    public function page(int $page): self
    {
        $this->query['p'] = $page;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return VenueSearchBuilder
     */
    public function withName(string $name): self
    {
        $this->query['name'] = $name;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return VenueSearchBuilder
     */
    public function withCity(string $name): self
    {
        $this->query['cityName'] = $name;

        return $this;
    }

    /**
     * @param int $id
     *
     * @return VenueSearchBuilder
     */
    public function withCityId(int $id): self
    {
        $this->query['cityId'] = $id;

        return $this;
    }

    /**
     * @param string $country
     *
     * @return VenueSearchBuilder
     */
    public function withCountry(string $country): self
    {
        $this->query['country'] = $country;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return VenueSearchBuilder
     */
    public function withState(string $name): self
    {
        $this->query['stateName'] = $name;

        return $this;
    }

    /**
     * @param string $code
     *
     * @return VenueSearchBuilder
     */
    public function withStateCode(string $code): self
    {
        $this->query['stateCode'] = $code;

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
