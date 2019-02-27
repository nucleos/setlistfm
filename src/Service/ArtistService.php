<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Service;

use Core23\SetlistFm\Exception\ApiException;
use Core23\SetlistFm\Exception\NotFoundException;
use Core23\SetlistFm\Model\Artist;

final class ArtistService extends AbstractService
{
    /**
     * Get the metadata for an artist.
     *
     * @param string $mbid
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return Artist
     */
    public function getArtist(string $mbid): Artist
    {
        return Artist::fromApi(
            $this->call('artist/'.$mbid)
        );
    }

    /**
     * Search for artists. Returns artists sorted by relevance.
     *
     * @param string|null $name
     * @param string|null $tmbid
     * @param string|null $mbid
     * @param int         $page
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return Artist[]
     */
    public function search(?string $name = null, ?string $tmbid = null, ?string $mbid = null, int $page = 1): array
    {
        $response = $this->call('search/artists', [
            'mbid'       => $mbid,
            'tmbid'      => $tmbid,
            'artistName' => $name,
            'p'          => $page,
        ]);

        if (!\array_key_exists('artist', $response)) {
            return [];
        }

        return array_map(function ($data) {
            return Artist::fromApi($data);
        }, $response['artist']);
    }
}
