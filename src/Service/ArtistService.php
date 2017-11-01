<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Service;

use Core23\SetlistFm\Exception\ApiException;
use Core23\SetlistFm\Exception\NotFoundException;

final class ArtistService extends AbstractService
{
    /**
     * Get the metadata for an artist.
     *
     * @param string $mbid
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getArtist(string $mbid): array
    {
        return $this->call('artist/'.$mbid);
    }

    /**
     * Search for artists. Returns artists sorted by relevance.
     *
     * @param string|null $name
     * @param string|null $tmbid
     * @param string|null $mbid
     * @param int         $page
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function search(? string $name = null, ? string $tmbid = null, ? string $mbid = null, int $page = 1) : array
    {
        return $this->call('search/artists', array(
            'mbid'       => $mbid,
            'tmbid'      => $tmbid,
            'artistName' => $name,
            'p'          => $page,
        ));
    }
}
