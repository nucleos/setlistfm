<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Model;

final class Setlist
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var Artist|null
     */
    private $artist;

    /**
     * @var Venue|null
     */
    private $venue;

    /**
     * @var Tour|null
     */
    private $tour;

    /**
     * @var Set[]
     */
    private $sets;

    /**
     * @var string|null
     */
    private $info;

    /**
     * @var string|null
     */
    private $url;

    /**
     * @var string|null
     */
    private $versionId;

    /**
     * @var \DateTime
     */
    private $eventDate;

    /**
     * @var \DateTime|null
     */
    private $updateDate;

    /**
     * Setlist constructor.
     *
     * @param string         $id
     * @param Artist|null    $artist
     * @param Venue|null     $venue
     * @param Tour|null      $tour
     * @param Set[]          $sets
     * @param null|string    $info
     * @param null|string    $url
     * @param null|string    $versionId
     * @param \DateTime      $eventDate
     * @param \DateTime|null $updateDate
     */
    public function __construct(
        string $id,
        ?Artist $artist,
        ?Venue $venue,
        ?Tour $tour,
        array $sets,
        ?string $info,
        ?string $url,
        ?string $versionId,
        \DateTime $eventDate,
        ?\DateTime $updateDate
    ) {
        $this->id         = $id;
        $this->artist     = $artist;
        $this->venue      = $venue;
        $this->tour       = $tour;
        $this->sets       = $sets;
        $this->info       = $info;
        $this->url        = $url;
        $this->versionId  = $versionId;
        $this->eventDate  = $eventDate;
        $this->updateDate = $updateDate;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return Artist|null
     */
    public function getArtist(): ?Artist
    {
        return $this->artist;
    }

    /**
     * @return Venue|null
     */
    public function getVenue(): ?Venue
    {
        return $this->venue;
    }

    /**
     * @return Tour|null
     */
    public function getTour(): ?Tour
    {
        return $this->tour;
    }

    /**
     * @return Set[]
     */
    public function getSets(): array
    {
        return $this->sets;
    }

    /**
     * @return null|string
     */
    public function getInfo(): ?string
    {
        return $this->info;
    }

    /**
     * @return null|string
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @return null|string
     */
    public function getVersionId(): ?string
    {
        return $this->versionId;
    }

    /**
     * @return \DateTime
     */
    public function getEventDate(): \DateTime
    {
        return $this->eventDate;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdateDate(): ?\DateTime
    {
        return $this->updateDate;
    }

    /**
     * @param array $data
     *
     * @return Setlist
     */
    public static function fromApi(array $data): self
    {
        $artist = null;
        $venue  = null;
        $tour   = null;
        $sets   = [];

        if (array_key_exists('artist', $data)) {
            $artist = Artist::fromApi($data['artist']);
        }
        if (array_key_exists('venue', $data)) {
            $venue = Venue::fromApi($data['venue']);
        }
        if (array_key_exists('tour', $data)) {
            $tour = Tour::fromApi($data['tour']);
        }

        $setData = [];

        if (array_key_exists('sets', $data) && array_key_exists('set', $data['sets'])) {
            $setData = $data['sets']['set'];
        } elseif (array_key_exists('set', $data)) {
            $setData = $data['set'];
        }

        foreach ($setData as $set) {
            $sets[] = Set::fromApi($set);
        }

        return new self(
            $data['id'],
            $artist,
            $venue,
            $tour,
            $sets,
            $data['info'] ?? null,
            $data['url'] ?? null,
            $data['versionId'] ?? null,
            new \DateTime($data['eventDate']),
            $data['lastUpdated'] ? new \DateTime($data['lastUpdated']) : null
        );
    }
}
