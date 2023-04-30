<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\SetlistFm\Service;

use Nucleos\SetlistFm\Connection\ConnectionInterface;
use Nucleos\SetlistFm\Exception\ApiException;
use Nucleos\SetlistFm\Exception\NotFoundException;
use Nucleos\SetlistFm\Model\Setlist;
use Nucleos\SetlistFm\Model\User;

final class UserService
{
    /**
     * @var ConnectionInterface
     */
    private $connection;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Get the user data for an id.
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getUser(string $userId): User
    {
        return User::fromApi(
            $this->connection->call('user/'.$userId)
        );
    }

    /**
     * Get a list of attended venues for a user id.
     *
     * @return Setlist[]
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getAttends(string $userId, int $page = 1): array
    {
        $response = $this->connection->call('user/'.$userId.'/attended', [
            'p' => $page,
        ]);

        if (!isset($response['setlist'])) {
            return [];
        }

        return array_map(static function (array $data): Setlist {
            return Setlist::fromApi($data);
        }, $response['setlist']);
    }

    /**
     * Get a list of edited venues for a user id.
     *
     * @return Setlist[]
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    public function getEdits(string $userId, int $page = 1): array
    {
        $response = $this->connection->call('user/'.$userId.'/edited', [
            'p' => $page,
        ]);

        if (!isset($response['setlist'])) {
            return [];
        }

        return array_map(static function (array $data): Setlist {
            return Setlist::fromApi($data);
        }, $response['setlist']);
    }
}
