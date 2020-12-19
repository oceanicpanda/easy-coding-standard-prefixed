<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper269dc521b0fa\Symfony\Component\Cache\Exception;

use _PhpScoper269dc521b0fa\Psr\Cache\CacheException as Psr6CacheInterface;
use _PhpScoper269dc521b0fa\Psr\SimpleCache\CacheException as SimpleCacheInterface;
if (\interface_exists(\_PhpScoper269dc521b0fa\Psr\SimpleCache\CacheException::class)) {
    class CacheException extends \Exception implements \_PhpScoper269dc521b0fa\Psr\Cache\CacheException, \_PhpScoper269dc521b0fa\Psr\SimpleCache\CacheException
    {
    }
} else {
    class CacheException extends \Exception implements \_PhpScoper269dc521b0fa\Psr\Cache\CacheException
    {
    }
}
