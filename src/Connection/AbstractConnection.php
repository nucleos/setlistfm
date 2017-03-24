<?php

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
    const DEFAULT_WS_ENDPOINT = 'https://api.setlist.fm/rest/0.1/';

    /**
     * Message for empty responses.
     */
    const NOT_FOUND_MESSAGE = 'not found';

    /**
     * @var string
     */
    protected $uri;

    /**
     * AbstractConnection constructor.
     *
     * @param string $uri
     */
    public function __construct(string $uri = null)
    {
        if (null === $uri) {
            $uri = static::DEFAULT_WS_ENDPOINT;
        }

        $this->uri = $uri;
    }
}
