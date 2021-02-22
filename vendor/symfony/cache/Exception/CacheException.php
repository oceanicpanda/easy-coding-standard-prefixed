<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperfcee700af3df\Symfony\Component\Cache\Exception;

use _PhpScoperfcee700af3df\Psr\Cache\CacheException as Psr6CacheInterface;
use _PhpScoperfcee700af3df\Psr\SimpleCache\CacheException as SimpleCacheInterface;
if (\interface_exists(\_PhpScoperfcee700af3df\Psr\SimpleCache\CacheException::class)) {
    class CacheException extends \Exception implements \_PhpScoperfcee700af3df\Psr\Cache\CacheException, \_PhpScoperfcee700af3df\Psr\SimpleCache\CacheException
    {
    }
} else {
    class CacheException extends \Exception implements \_PhpScoperfcee700af3df\Psr\Cache\CacheException
    {
    }
}
