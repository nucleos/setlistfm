<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Model;

final class User
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string|null
     */
    private $fullname;

    /**
     * @var string|null
     */
    private $about;

    /**
     * @var string|null
     */
    private $website;

    /**
     * @var string|null
     */
    private $url;

    /**
     * @param string      $id
     * @param string|null $fullname
     * @param string|null $about
     * @param string|null $website
     * @param string|null $url
     */
    public function __construct(string $id, ?string $fullname, ?string $about, ?string $website, ?string $url)
    {
        $this->id       = $id;
        $this->fullname = $fullname;
        $this->about    = $about;
        $this->website  = $website;
        $this->url      = $url;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    /**
     * @return string|null
     */
    public function getAbout(): ?string
    {
        return $this->about;
    }

    /**
     * @return string|null
     */
    public function getWebsite(): ?string
    {
        return $this->website;
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
     * @return User
     */
    public static function fromApi(array $data): self
    {
        return new self(
            $data['userId'],
            $data['fullname'] ?? null,
            $data['about'] ?? null,
            $data['website'] ?? null,
            $data['url'] ?? null
        );
    }
}
