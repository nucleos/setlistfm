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
use Core23\SetlistFm\Model\Setlist;
use Core23\SetlistFm\Model\User;

final class UserService extends AbstractService
{
    /**
     * Get the user data for an id.
     *
     * @param string $userId
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return User
     */
    public function getUser(string $userId): User
    {
        return User::fromApi(
            $this->call('user/'.$userId)
        );
    }

    /**
     * Get a list of attended venues for a user id.
     *
     * @param string $userId
     * @param int    $page
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return Setlist[]
     */
    public function getAttends(string $userId, int $page = 1): array
    {
        $response = $this->call('user/'.$userId.'/attended', [
            'p' => $page,
        ]);

        if (!\array_key_exists('setlist', $response)) {
            return [];
        }

        return array_map(function ($data) {
            return Setlist::fromApi($data);
        }, $response['setlist']);
    }

    /**
     * Get a list of edited venues for a user id.
     *
     * @param string $userId
     * @param int    $page
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return Setlist[]
     */
    public function getEdits(string $userId, int $page = 1): array
    {
        $response = $this->call('user/'.$userId.'/edited', [
            'p' => $page,
        ]);

        if (!\array_key_exists('setlist', $response)) {
            return [];
        }

        return array_map(function ($data) {
            return Setlist::fromApi($data);
        }, $response['setlist']);
    }
}
