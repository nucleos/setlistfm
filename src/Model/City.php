<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\SetlistFm\Model;

final class City
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $state;

    /**
     * @var string|null
     */
    private $stateCode;

    /**
     * @var Country|null
     */
    private $country;

    /**
     * @var Geo|null
     */
    private $geo;

    public function __construct(
        int $id,
        string $name,
        ?string $state,
        ?string $stateCode,
        ?Country $county,
        ?Geo $geo
    ) {
        $this->id        = $id;
        $this->name      = $name;
        $this->state     = $state;
        $this->stateCode = $stateCode;
        $this->country   = $county;
        $this->geo       = $geo;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function getStateCode(): ?string
    {
        return $this->stateCode;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function getGeo(): ?Geo
    {
        return $this->geo;
    }

    /**
     * @return City
     */
    public static function fromApi(array $data): self
    {
        $geo     = null;
        $country = null;

        if ($data['coords']) {
            $geo = Geo::fromApi($data['coords']);
        }

        if ($data['country']) {
            $country = Country::fromApi($data['country']);
        }

        return new self(
            (int) $data['id'],
            $data['name'],
            $data['state'] ?? null,
            $data['stateCode'] ?? null,
            $country,
            $geo
        );
    }
}
