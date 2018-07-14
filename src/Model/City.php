<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Model;

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
    private $county;

    /**
     * @var Geo|null
     */
    private $geo;

    /**
     * @param int          $id
     * @param string       $name
     * @param null|string  $state
     * @param null|string  $stateCode
     * @param Country|null $county
     * @param Geo|null     $geo
     */
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
        $this->county    = $county;
        $this->geo       = $geo;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return null|string
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @return null|string
     */
    public function getStateCode(): ?string
    {
        return $this->stateCode;
    }

    /**
     * @return Country|null
     */
    public function getCounty(): ?Country
    {
        return $this->county;
    }

    /**
     * @return Geo|null
     */
    public function getGeo(): ?Geo
    {
        return $this->geo;
    }

    /**
     * @param array $data
     *
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
            $data['state'],
            $data['stateCode'],
            $country,
            $geo
        );
    }
}
