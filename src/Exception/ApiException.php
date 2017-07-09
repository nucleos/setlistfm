<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Exception;

final class ApiException extends \Exception
{
    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getCode().': '.$this->getMessage();
    }
}
