<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper3f3a54dd086f\Symfony\Component\Cache\Messenger;

use _PhpScoper3f3a54dd086f\Psr\Log\LoggerInterface;
use _PhpScoper3f3a54dd086f\Symfony\Component\Cache\Adapter\AdapterInterface;
use _PhpScoper3f3a54dd086f\Symfony\Component\Cache\CacheItem;
use _PhpScoper3f3a54dd086f\Symfony\Component\DependencyInjection\ReverseContainer;
use _PhpScoper3f3a54dd086f\Symfony\Component\Messenger\MessageBusInterface;
use _PhpScoper3f3a54dd086f\Symfony\Component\Messenger\Stamp\HandledStamp;
/**
 * Sends the computation of cached values to a message bus.
 */
class EarlyExpirationDispatcher
{
    private $bus;
    private $reverseContainer;
    private $callbackWrapper;
    public function __construct(\_PhpScoper3f3a54dd086f\Symfony\Component\Messenger\MessageBusInterface $bus, \_PhpScoper3f3a54dd086f\Symfony\Component\DependencyInjection\ReverseContainer $reverseContainer, callable $callbackWrapper = null)
    {
        $this->bus = $bus;
        $this->reverseContainer = $reverseContainer;
        $this->callbackWrapper = $callbackWrapper;
    }
    public function __invoke(callable $callback, \_PhpScoper3f3a54dd086f\Symfony\Component\Cache\CacheItem $item, bool &$save, \_PhpScoper3f3a54dd086f\Symfony\Component\Cache\Adapter\AdapterInterface $pool, \Closure $setMetadata, \_PhpScoper3f3a54dd086f\Psr\Log\LoggerInterface $logger = null)
    {
        if (!$item->isHit() || null === ($message = \_PhpScoper3f3a54dd086f\Symfony\Component\Cache\Messenger\EarlyExpirationMessage::create($this->reverseContainer, $callback, $item, $pool))) {
            // The item is stale or the callback cannot be reversed: we must compute the value now
            $logger && $logger->info('Computing item "{key}" online: ' . ($item->isHit() ? 'callback cannot be reversed' : 'item is stale'), ['key' => $item->getKey()]);
            return null !== $this->callbackWrapper ? ($this->callbackWrapper)($callback, $item, $save, $pool, $setMetadata, $logger) : $callback($item, $save);
        }
        $envelope = $this->bus->dispatch($message);
        if ($logger) {
            if ($envelope->last(\_PhpScoper3f3a54dd086f\Symfony\Component\Messenger\Stamp\HandledStamp::class)) {
                $logger->info('Item "{key}" was computed online', ['key' => $item->getKey()]);
            } else {
                $logger->info('Item "{key}" sent for recomputation', ['key' => $item->getKey()]);
            }
        }
        // The item's value is not stale, no need to write it to the backend
        $save = \false;
        return $message->getItem()->get() ?? $item->get();
    }
}