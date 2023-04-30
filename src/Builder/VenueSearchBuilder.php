<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\SetlistFm\Builder;

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

    public static function create(): self
    {
        return new static();
    }

    public function page(int $page): self
    {
        $this->query['p'] = $page;

        return $this;
    }

    public function withName(string $name): self
    {
        $this->query['name'] = $name;

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

    public function withCountry(string $country): self
    {
        $this->query['country'] = $country;

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

    public function getQuery(): array
    {
        return $this->query;
    }
}
