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
     * @return array
     */
    public function getUser(string $userId): array
    {
        return $this->call('user/'.$userId);
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
     * @return array
     */
    public function getAttends(string $userId, int $page = 1): array
    {
        return $this->call('user/'.$userId.'/attended', [
            'p' => $page,
        ]);
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
     * @return array
     */
    public function getEdits(string $userId, int $page = 1): array
    {
        return $this->call('user/'.$userId.'/edited', [
            'p' => $page,
        ]);
    }
}
