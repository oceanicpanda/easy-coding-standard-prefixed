<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper78e1a27e740b\Symfony\Component\HttpKernel\Debug;

use _PhpScoper78e1a27e740b\Symfony\Component\EventDispatcher\Debug\TraceableEventDispatcher as BaseTraceableEventDispatcher;
use _PhpScoper78e1a27e740b\Symfony\Component\HttpKernel\KernelEvents;
/**
 * Collects some data about event listeners.
 *
 * This event dispatcher delegates the dispatching to another one.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class TraceableEventDispatcher extends BaseTraceableEventDispatcher
{
    /**
     * {@inheritdoc}
     */
    protected function beforeDispatch(string $eventName, object $event)
    {
        switch ($eventName) {
            case KernelEvents::REQUEST:
                $this->stopwatch->openSection();
                break;
            case KernelEvents::VIEW:
            case KernelEvents::RESPONSE:
                // stop only if a controller has been executed
                if ($this->stopwatch->isStarted('controller')) {
                    $this->stopwatch->stop('controller');
                }
                break;
            case KernelEvents::TERMINATE:
                $token = $event->getResponse()->headers->get('X-Debug-Token');
                if (null === $token) {
                    break;
                }
                // There is a very special case when using built-in AppCache class as kernel wrapper, in the case
                // of an ESI request leading to a `stale` response [B]  inside a `fresh` cached response [A].
                // In this case, `$token` contains the [B] debug token, but the  open `stopwatch` section ID
                // is equal to the [A] debug token. Trying to reopen section with the [B] token throws an exception
                // which must be caught.
                try {
                    $this->stopwatch->openSection($token);
                } catch (\LogicException $e) {
                }
                break;
        }
    }
    /**
     * {@inheritdoc}
     */
    protected function afterDispatch(string $eventName, object $event)
    {
        switch ($eventName) {
            case KernelEvents::CONTROLLER_ARGUMENTS:
                $this->stopwatch->start('controller', 'section');
                break;
            case KernelEvents::RESPONSE:
                $token = $event->getResponse()->headers->get('X-Debug-Token');
                if (null === $token) {
                    break;
                }
                $this->stopwatch->stopSection($token);
                break;
            case KernelEvents::TERMINATE:
                // In the special case described in the `preDispatch` method above, the `$token` section
                // does not exist, then closing it throws an exception which must be caught.
                $token = $event->getResponse()->headers->get('X-Debug-Token');
                if (null === $token) {
                    break;
                }
                try {
                    $this->stopwatch->stopSection($token);
                } catch (\LogicException $e) {
                }
                break;
        }
    }
}
