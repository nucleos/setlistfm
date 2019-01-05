<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Model;

final class Song
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $info;

    /**
     * @var Artist|null
     */
    private $cover;

    /**
     * @var bool
     */
    private $taped;

    /**
     * @var Artist[]
     */
    private $featurings;

    /**
     * @param string      $name
     * @param string|null $info
     * @param Artist|null $cover
     * @param bool        $taped
     * @param Artist[]    $featurings
     */
    public function __construct(string $name, ?string $info, ?Artist $cover, bool $taped, array $featurings)
    {
        $this->name       = $name;
        $this->info       = $info;
        $this->cover      = $cover;
        $this->taped      = $taped;
        $this->featurings = $featurings;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getInfo(): ?string
    {
        return $this->info;
    }

    /**
     * @return Artist|null
     */
    public function getCover(): ?Artist
    {
        return $this->cover;
    }

    /**
     * @return bool
     */
    public function isTaped(): bool
    {
        return $this->taped;
    }

    /**
     * @return Artist[]
     */
    public function getFeaturings(): array
    {
        return $this->featurings;
    }

    /**
     * @param array $data
     *
     * @return Song
     */
    public static function fromApi(array $data): self
    {
        $featuring = [];

        if (array_key_exists('with', $data)) {
            $featuring[] = Artist::fromApi($data['with']);
        }

        return new self(
            $data['name'],
            $data['info'] ?? null,
            isset($data['cover']) ? Artist::fromApi($data['cover']) : null,
            isset($data['tape']) ? (bool) $data['tape'] : false,
            $featuring
        );
    }
}
