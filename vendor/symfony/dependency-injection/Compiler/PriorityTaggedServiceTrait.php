<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper78e1a27e740b\Symfony\Component\DependencyInjection\Compiler;

use _PhpScoper78e1a27e740b\Symfony\Component\DependencyInjection\Argument\TaggedIteratorArgument;
use _PhpScoper78e1a27e740b\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoper78e1a27e740b\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use _PhpScoper78e1a27e740b\Symfony\Component\DependencyInjection\Reference;
use _PhpScoper78e1a27e740b\Symfony\Component\DependencyInjection\TypedReference;
/**
 * Trait that allows a generic method to find and sort service by priority option in the tag.
 *
 * @author Iltar van der Berg <kjarli@gmail.com>
 */
trait PriorityTaggedServiceTrait
{
    /**
     * Finds all services with the given tag name and order them by their priority.
     *
     * The order of additions must be respected for services having the same priority,
     * and knowing that the \SplPriorityQueue class does not respect the FIFO method,
     * we should not use that class.
     *
     * @see https://bugs.php.net/53710
     * @see https://bugs.php.net/60926
     *
     * @param string|TaggedIteratorArgument $tagName
     *
     * @return Reference[]
     */
    private function findAndSortTaggedServices($tagName, ContainerBuilder $container) : array
    {
        $indexAttribute = $defaultIndexMethod = $needsIndexes = $defaultPriorityMethod = null;
        if ($tagName instanceof TaggedIteratorArgument) {
            $indexAttribute = $tagName->getIndexAttribute();
            $defaultIndexMethod = $tagName->getDefaultIndexMethod();
            $needsIndexes = $tagName->needsIndexes();
            $defaultPriorityMethod = $tagName->getDefaultPriorityMethod() ?? 'getDefaultPriority';
            $tagName = $tagName->getTag();
        }
        $i = 0;
        $services = [];
        foreach ($container->findTaggedServiceIds($tagName, \true) as $serviceId => $attributes) {
            $defaultPriority = null;
            $defaultIndex = null;
            $class = $container->getDefinition($serviceId)->getClass();
            $class = $container->getParameterBag()->resolveValue($class) ?: null;
            foreach ($attributes as $attribute) {
                $index = $priority = null;
                if (isset($attribute['priority'])) {
                    $priority = $attribute['priority'];
                } elseif (null === $defaultPriority && $defaultPriorityMethod && $class) {
                    $defaultPriority = \_PhpScoper78e1a27e740b\Symfony\Component\DependencyInjection\Compiler\PriorityTaggedServiceUtil::getDefaultPriority($container, $serviceId, $class, $defaultPriorityMethod, $tagName);
                }
                $priority = $priority ?? $defaultPriority ?? ($defaultPriority = 0);
                if (null === $indexAttribute && !$defaultIndexMethod && !$needsIndexes) {
                    $services[] = [$priority, ++$i, null, $serviceId, null];
                    continue 2;
                }
                if (null !== $indexAttribute && isset($attribute[$indexAttribute])) {
                    $index = $attribute[$indexAttribute];
                } elseif (null === $defaultIndex && $defaultPriorityMethod && $class) {
                    $defaultIndex = \_PhpScoper78e1a27e740b\Symfony\Component\DependencyInjection\Compiler\PriorityTaggedServiceUtil::getDefaultIndex($container, $serviceId, $class, $defaultIndexMethod ?? 'getDefaultName', $tagName, $indexAttribute);
                }
                $index = $index ?? $defaultIndex ?? ($defaultIndex = $serviceId);
                $services[] = [$priority, ++$i, $index, $serviceId, $class];
            }
        }
        \uasort($services, static function ($a, $b) {
            return $b[0] <=> $a[0] ?: $a[1] <=> $b[1];
        });
        $refs = [];
        foreach ($services as [, , $index, $serviceId, $class]) {
            if (!$class) {
                $reference = new Reference($serviceId);
            } elseif ($index === $serviceId) {
                $reference = new TypedReference($serviceId, $class);
            } else {
                $reference = new TypedReference($serviceId, $class, ContainerBuilder::EXCEPTION_ON_INVALID_REFERENCE, $index);
            }
            if (null === $index) {
                $refs[] = $reference;
            } else {
                $refs[$index] = $reference;
            }
        }
        return $refs;
    }
}
/**
 * @internal
 */
class PriorityTaggedServiceUtil
{
    /**
     * Gets the index defined by the default index method.
     */
    public static function getDefaultIndex(ContainerBuilder $container, string $serviceId, string $class, string $defaultIndexMethod, string $tagName, ?string $indexAttribute) : ?string
    {
        if (!($r = $container->getReflectionClass($class)) || !$r->hasMethod($defaultIndexMethod)) {
            return null;
        }
        if (null !== $indexAttribute) {
            $service = $class !== $serviceId ? \sprintf('service "%s"', $serviceId) : 'on the corresponding service';
            $message = [\sprintf('Either method "%s::%s()" should ', $class, $defaultIndexMethod), \sprintf(' or tag "%s" on %s is missing attribute "%s".', $tagName, $service, $indexAttribute)];
        } else {
            $message = [\sprintf('Method "%s::%s()" should ', $class, $defaultIndexMethod), '.'];
        }
        if (!($rm = $r->getMethod($defaultIndexMethod))->isStatic()) {
            throw new InvalidArgumentException(\implode('be static', $message));
        }
        if (!$rm->isPublic()) {
            throw new InvalidArgumentException(\implode('be public', $message));
        }
        $defaultIndex = $rm->invoke(null);
        if (!\is_string($defaultIndex)) {
            throw new InvalidArgumentException(\implode(\sprintf('return a string (got "%s")', \get_debug_type($defaultIndex)), $message));
        }
        return $defaultIndex;
    }
    /**
     * Gets the priority defined by the default priority method.
     */
    public static function getDefaultPriority(ContainerBuilder $container, string $serviceId, string $class, string $defaultPriorityMethod, string $tagName) : ?int
    {
        if (!($r = $container->getReflectionClass($class)) || !$r->hasMethod($defaultPriorityMethod)) {
            return null;
        }
        if (!($rm = $r->getMethod($defaultPriorityMethod))->isStatic()) {
            throw new InvalidArgumentException(\sprintf('Either method "%s::%s()" should be static or tag "%s" on service "%s" is missing attribute "priority".', $class, $defaultPriorityMethod, $tagName, $serviceId));
        }
        if (!$rm->isPublic()) {
            throw new InvalidArgumentException(\sprintf('Either method "%s::%s()" should be public or tag "%s" on service "%s" is missing attribute "priority".', $class, $defaultPriorityMethod, $tagName, $serviceId));
        }
        $defaultPriority = $rm->invoke(null);
        if (!\is_int($defaultPriority)) {
            throw new InvalidArgumentException(\sprintf('Method "%s::%s()" should return an integer (got "%s") or tag "%s" on service "%s" is missing attribute "priority".', $class, $defaultPriorityMethod, \get_debug_type($defaultPriority), $tagName, $serviceId));
        }
        return $defaultPriority;
    }
}
