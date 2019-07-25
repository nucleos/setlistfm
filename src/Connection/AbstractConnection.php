<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Connection;

abstract class AbstractConnection implements ConnectionInterface
{
    /**
     * Default Endpoint.
     */
    public const DEFAULT_WS_ENDPOINT = 'https://api.setlist.fm/rest/1.0/';

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $uri;

    /**
     * @param string $uri
     */
    public function __construct(string $apikey, string $uri = null)
    {
        if (null === $uri) {
            $uri = static::DEFAULT_WS_ENDPOINT;
        }

        $this->apiKey = $apikey;
        $this->uri    = $uri;
    }

    final protected function getApiKey(): string
    {
        return $this->apiKey;
    }

    final protected function getUri(): string
    {
        return $this->uri;
    }
}
