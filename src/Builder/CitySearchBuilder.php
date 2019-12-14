<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Builder;

final class CitySearchBuilder
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
     * @return CitySearchBuilder
     */
    public static function create(): self
    {
        return new static();
    }

    /**
     * @return CitySearchBuilder
     */
    public function page(int $page): self
    {
        $this->query['p'] = $page;

        return $this;
    }

    /**
     * @return CitySearchBuilder
     */
    public function withName(string $name): self
    {
        $this->query['name'] = $name;

        return $this;
    }

    /**
     * @return CitySearchBuilder
     */
    public function withCountry(string $country): self
    {
        $this->query['country'] = $country;

        return $this;
    }

    /**
     * @return CitySearchBuilder
     */
    public function withState(string $name): self
    {
        $this->query['state'] = $name;

        return $this;
    }

    /**
     * @return CitySearchBuilder
     */
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
