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

    public function __construct(string $id, ?string $fullname, ?string $about, ?string $website, ?string $url)
    {
        $this->id       = $id;
        $this->fullname = $fullname;
        $this->about    = $about;
        $this->website  = $website;
        $this->url      = $url;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
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
