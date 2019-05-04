<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Model;

final class CountrySearchResult
{
    /**
     * @var Country[]
     */
    private $result;

    /**
     * @var int
     */
    private $page;

    /**
     * @var int
     */
    private $pageSize;

    /**
     * @var int
     */
    private $totalSize;

    /**
     * @param Country[] $result
     * @param int       $page
     * @param int       $pageSize
     * @param int       $totalSize
     */
    private function __construct(array $result, int $page, int $pageSize, int $totalSize)
    {
        $this->result    = $result;
        $this->page      = $page;
        $this->pageSize  = $pageSize;
        $this->totalSize = $totalSize;
    }

    /**
     * @return Country[]
     */
    public function getResult(): array
    {
        return $this->result;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    /**
     * @return int
     */
    public function getTotalSize(): int
    {
        return $this->totalSize;
    }

    /**
     * @return int
     */
    public function getLastPage(): int
    {
        return (int) floor($this->totalSize / $this->pageSize);
    }

    /**
     * @return CountrySearchResult
     */
    public static function createEmpty(): self
    {
        return new self([], 0, 0, 0);
    }

    /**
     * @param array $response
     *
     * @return CountrySearchResult
     */
    public static function fromApi(array $response): self
    {
        return new self(
            array_map(
                static function ($data) {
                    return Country::fromApi($data);
                },
                $response['country']
            ),
            (int) $response['page'],
            (int) $response['itemsPerPage'],
            (int) $response['total']
        );
    }
}
