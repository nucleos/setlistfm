<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\SetlistFm\Model;

/**
 * @psalm-immutable
 */
final class Venue
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $url;

    /**
     * @var City|null
     */
    private $city;

    public function __construct(string $id, string $name, ?string $url, ?City $city)
    {
        $this->id   = $id;
        $this->name = $name;
        $this->url  = $url;
        $this->city = $city;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    /**
     * @return Venue
     */
    public static function fromApi(array $data): self
    {
        $city = null;

        if ($data['city']) {
            $city = City::fromApi($data['city']);
        }

        return new self(
            $data['id'],
            $data['name'],
            $data['url'] ?? null,
            $city
        );
    }
}
