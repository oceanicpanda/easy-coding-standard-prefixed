<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperb09c3ec8e01a\Symfony\Component\Cache\DependencyInjection;

use _PhpScoperb09c3ec8e01a\Symfony\Component\Cache\PruneableInterface;
use _PhpScoperb09c3ec8e01a\Symfony\Component\DependencyInjection\Argument\IteratorArgument;
use _PhpScoperb09c3ec8e01a\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use _PhpScoperb09c3ec8e01a\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoperb09c3ec8e01a\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use _PhpScoperb09c3ec8e01a\Symfony\Component\DependencyInjection\Reference;
/**
 * @author Rob Frawley 2nd <rmf@src.run>
 */
class CachePoolPrunerPass implements \_PhpScoperb09c3ec8e01a\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    private $cacheCommandServiceId;
    private $cachePoolTag;
    public function __construct(string $cacheCommandServiceId = 'console.command.cache_pool_prune', string $cachePoolTag = 'cache.pool')
    {
        $this->cacheCommandServiceId = $cacheCommandServiceId;
        $this->cachePoolTag = $cachePoolTag;
    }
    /**
     * {@inheritdoc}
     */
    public function process(\_PhpScoperb09c3ec8e01a\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        if (!$container->hasDefinition($this->cacheCommandServiceId)) {
            return;
        }
        $services = [];
        foreach ($container->findTaggedServiceIds($this->cachePoolTag) as $id => $tags) {
            $class = $container->getParameterBag()->resolveValue($container->getDefinition($id)->getClass());
            if (!($reflection = $container->getReflectionClass($class))) {
                throw new \_PhpScoperb09c3ec8e01a\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException(\sprintf('Class "%s" used for service "%s" cannot be found.', $class, $id));
            }
            if ($reflection->implementsInterface(\_PhpScoperb09c3ec8e01a\Symfony\Component\Cache\PruneableInterface::class)) {
                $services[$id] = new \_PhpScoperb09c3ec8e01a\Symfony\Component\DependencyInjection\Reference($id);
            }
        }
        $container->getDefinition($this->cacheCommandServiceId)->replaceArgument(0, new \_PhpScoperb09c3ec8e01a\Symfony\Component\DependencyInjection\Argument\IteratorArgument($services));
    }
}
