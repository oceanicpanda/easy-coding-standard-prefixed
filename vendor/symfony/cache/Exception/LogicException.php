<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper70072c07b02b\Symfony\Component\Cache\Exception;

use _PhpScoper70072c07b02b\Psr\Cache\CacheException as Psr6CacheInterface;
use _PhpScoper70072c07b02b\Psr\SimpleCache\CacheException as SimpleCacheInterface;
if (\interface_exists(\_PhpScoper70072c07b02b\Psr\SimpleCache\CacheException::class)) {
    class LogicException extends \LogicException implements \_PhpScoper70072c07b02b\Psr\Cache\CacheException, \_PhpScoper70072c07b02b\Psr\SimpleCache\CacheException
    {
    }
} else {
    class LogicException extends \LogicException implements \_PhpScoper70072c07b02b\Psr\Cache\CacheException
    {
    }
}
