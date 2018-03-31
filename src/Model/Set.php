<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Model;

final class Set
{
    /**
     * @var string|null
     */
    private $name;

    /**
     * @var int|null
     */
    private $encore;

    /**
     * @var Song[]
     */
    private $songs;

    /**
     * Set constructor.
     *
     * @param null|string $name
     * @param int|null    $encore
     * @param Song[]      $songs
     */
    public function __construct(?string $name, ?int $encore, array $songs)
    {
        $this->name   = $name;
        $this->encore = $encore;
        $this->songs  = $songs;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return int|null
     */
    public function getEncore(): ?int
    {
        return $this->encore;
    }

    /**
     * @return Song[]
     */
    public function getSongs(): array
    {
        return $this->songs;
    }

    /**
     * @param array $data
     *
     * @return Set
     */
    public static function fromApi(array $data): self
    {
        $songs = [];

        foreach ((array) $data['song'] as $song) {
            $songs[] = Song::fromApi($song);
        }

        return new self(
            $data['name'] ?? null,
            $data['encore'] ?? null,
            $songs
        );
    }
}
