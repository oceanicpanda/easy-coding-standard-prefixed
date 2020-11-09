<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper0d0ee1ba46d4\Symfony\Contracts\Cache;

use _PhpScoper0d0ee1ba46d4\Psr\Cache\CacheItemPoolInterface;
use _PhpScoper0d0ee1ba46d4\Psr\Cache\InvalidArgumentException;
use _PhpScoper0d0ee1ba46d4\Psr\Log\LoggerInterface;
/**
 * An implementation of CacheInterface for PSR-6 CacheItemPoolInterface classes.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
trait CacheTrait
{
    /**
     * {@inheritdoc}
     */
    public function get(string $key, callable $callback, float $beta = null, array &$metadata = null)
    {
        return $this->doGet($this, $key, $callback, $beta, $metadata);
    }
    /**
     * {@inheritdoc}
     */
    public function delete(string $key) : bool
    {
        return $this->deleteItem($key);
    }
    private function doGet(\_PhpScoper0d0ee1ba46d4\Psr\Cache\CacheItemPoolInterface $pool, string $key, callable $callback, ?float $beta, array &$metadata = null, \_PhpScoper0d0ee1ba46d4\Psr\Log\LoggerInterface $logger = null)
    {
        if (0 > ($beta = $beta ?? 1.0)) {
            throw new class(\sprintf('Argument "$beta" provided to "%s::get()" must be a positive number, %f given.', \get_class($this), $beta)) extends \InvalidArgumentException implements \_PhpScoper0d0ee1ba46d4\Psr\Cache\InvalidArgumentException
            {
            };
        }
        $item = $pool->getItem($key);
        $recompute = !$item->isHit() || \INF === $beta;
        $metadata = $item instanceof \_PhpScoper0d0ee1ba46d4\Symfony\Contracts\Cache\ItemInterface ? $item->getMetadata() : [];
        if (!$recompute && $metadata) {
            $expiry = $metadata[\_PhpScoper0d0ee1ba46d4\Symfony\Contracts\Cache\ItemInterface::METADATA_EXPIRY] ?? \false;
            $ctime = $metadata[\_PhpScoper0d0ee1ba46d4\Symfony\Contracts\Cache\ItemInterface::METADATA_CTIME] ?? \false;
            if ($recompute = $ctime && $expiry && $expiry <= ($now = \microtime(\true)) - $ctime / 1000 * $beta * \log(\random_int(1, \PHP_INT_MAX) / \PHP_INT_MAX)) {
                // force applying defaultLifetime to expiry
                $item->expiresAt(null);
                $logger && $logger->info('Item "{key}" elected for early recomputation {delta}s before its expiration', ['key' => $key, 'delta' => \sprintf('%.1f', $expiry - $now)]);
            }
        }
        if ($recompute) {
            $save = \true;
            $item->set($callback($item, $save));
            if ($save) {
                $pool->save($item);
            }
        }
        return $item->get();
    }
}