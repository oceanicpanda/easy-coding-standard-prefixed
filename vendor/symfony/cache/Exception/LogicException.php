<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperc4ea0f0bd23f\Symfony\Component\Cache\Exception;

use _PhpScoperc4ea0f0bd23f\Psr\Cache\CacheException as Psr6CacheInterface;
use _PhpScoperc4ea0f0bd23f\Psr\SimpleCache\CacheException as SimpleCacheInterface;
if (\interface_exists(\_PhpScoperc4ea0f0bd23f\Psr\SimpleCache\CacheException::class)) {
    class LogicException extends \LogicException implements \_PhpScoperc4ea0f0bd23f\Psr\Cache\CacheException, \_PhpScoperc4ea0f0bd23f\Psr\SimpleCache\CacheException
    {
    }
} else {
    class LogicException extends \LogicException implements \_PhpScoperc4ea0f0bd23f\Psr\Cache\CacheException
    {
    }
}
