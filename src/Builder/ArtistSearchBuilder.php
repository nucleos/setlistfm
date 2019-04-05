<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Builder;

use InvalidArgumentException;

final class ArtistSearchBuilder
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
     * @return ArtistSearchBuilder
     */
    public static function create(): self
    {
        return new static();
    }

    /**
     * @param int $page
     *
     * @return ArtistSearchBuilder
     */
    public function page(int $page): self
    {
        $this->query['p'] = $page;

        return $this;
    }

    /**
     * @param string $mode
     *
     * @return ArtistSearchBuilder
     */
    public function sort(string $mode): self
    {
        if (!\in_array($mode, ['sortName', 'relevance'], true)) {
            throw new InvalidArgumentException(sprintf('Invalid sort mode given: %s', $mode));
        }

        $this->query['sort'] = $mode;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return ArtistSearchBuilder
     */
    public function withName(string $name): self
    {
        $this->query['artistName'] = $name;

        return $this;
    }

    /**
     * @param string $mbid
     *
     * @return ArtistSearchBuilder
     */
    public function withMbid(string $mbid): self
    {
        $this->query['artistMbid'] = $mbid;

        return $this;
    }

    /**
     * @param int $tmid
     *
     * @return ArtistSearchBuilder
     */
    public function withTmbid(int $tmid): self
    {
        $this->query['artistTmid'] = $tmid;

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
