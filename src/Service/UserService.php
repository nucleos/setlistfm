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

final class UserService extends AbstractService
{
    /**
     * Get the user data for an id.
     *
     * @param string $userId
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getUser(string $userId): array
    {
        return $this->call('user/'.$userId);
    }

    /**
     * Get a list of attended venues for an user id.
     *
     * @param string $userId
     * @param int    $page
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getAttends(string $userId, int $page = 1): array
    {
        return $this->call('user/'.$userId.'/attended', array(
            'p' => $page,
        ));
    }

    /**
     * Get a list of edited venues for an user id.
     *
     * @param string $userId
     * @param int    $page
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getEdits(string $userId, int $page = 1): array
    {
        return $this->call('user/'.$userId.'/edited', array(
            'p' => $page,
        ));
    }
}
