<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScopere341acab57d4\Symfony\Component\Cache\Exception;

use _PhpScopere341acab57d4\Psr\Cache\CacheException as Psr6CacheInterface;
use _PhpScopere341acab57d4\Psr\SimpleCache\CacheException as SimpleCacheInterface;
if (\interface_exists(\_PhpScopere341acab57d4\Psr\SimpleCache\CacheException::class)) {
    class LogicException extends \LogicException implements \_PhpScopere341acab57d4\Psr\Cache\CacheException, \_PhpScopere341acab57d4\Psr\SimpleCache\CacheException
    {
    }
} else {
    class LogicException extends \LogicException implements \_PhpScopere341acab57d4\Psr\Cache\CacheException
    {
    }
}
