<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScopera51a90153f58\Symfony\Component\Cache\Exception;

use _PhpScopera51a90153f58\Psr\Cache\CacheException as Psr6CacheInterface;
use _PhpScopera51a90153f58\Psr\SimpleCache\CacheException as SimpleCacheInterface;
if (\interface_exists(\_PhpScopera51a90153f58\Psr\SimpleCache\CacheException::class)) {
    class LogicException extends \LogicException implements \_PhpScopera51a90153f58\Psr\Cache\CacheException, \_PhpScopera51a90153f58\Psr\SimpleCache\CacheException
    {
    }
} else {
    class LogicException extends \LogicException implements \_PhpScopera51a90153f58\Psr\Cache\CacheException
    {
    }
}
