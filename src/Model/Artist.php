<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Model;

final class Artist
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $mbid;

    /**
     * @var int|null
     */
    private $tmid;

    /**
     * @var string|null
     */
    private $sortName;

    /**
     * @var string|null
     */
    private $disambiguation;

    /**
     * @var string|null
     */
    private $url;

    /**
     * @param string      $name
     * @param string|null $mbid
     * @param int|null    $tmid
     * @param string|null $sortName
     * @param string|null $disambiguation
     * @param string|null $url
     */
    public function __construct(
        string $name,
        ?string $mbid,
        ?int $tmid,
        ?string $sortName,
        ?string $disambiguation,
        ?string $url
    ) {
        $this->name           = $name;
        $this->mbid           = $mbid;
        $this->tmid           = $tmid;
        $this->sortName       = $sortName;
        $this->disambiguation = $disambiguation;
        $this->url            = $url;
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
    public function getMbid(): ?string
    {
        return $this->mbid;
    }

    /**
     * @return int|null
     */
    public function getTmid(): ?int
    {
        return $this->tmid;
    }

    /**
     * @return string|null
     */
    public function getSortName(): ?string
    {
        return $this->sortName;
    }

    /**
     * @return string|null
     */
    public function getDisambiguation(): ?string
    {
        return $this->disambiguation;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param array $data
     *
     * @return Artist
     */
    public static function fromApi(array $data): self
    {
        return new self(
            $data['name'],
            $data['mbid'] ?? null,
            $data['tmid'] ?? null,
            $data['sortName'] ?? null,
            $data['disambiguation'] ?? null,
            $data['url'] ?? null
        );
    }
}
