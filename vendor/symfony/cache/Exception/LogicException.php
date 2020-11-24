<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperbd5fb781fe24\Symfony\Component\Cache\Exception;

use _PhpScoperbd5fb781fe24\Psr\Cache\CacheException as Psr6CacheInterface;
use _PhpScoperbd5fb781fe24\Psr\SimpleCache\CacheException as SimpleCacheInterface;
if (\interface_exists(\_PhpScoperbd5fb781fe24\Psr\SimpleCache\CacheException::class)) {
    class LogicException extends \LogicException implements \_PhpScoperbd5fb781fe24\Psr\Cache\CacheException, \_PhpScoperbd5fb781fe24\Psr\SimpleCache\CacheException
    {
    }
} else {
    class LogicException extends \LogicException implements \_PhpScoperbd5fb781fe24\Psr\Cache\CacheException
    {
    }
}
