<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper78e1a27e740b\Symfony\Component\HttpKernel\DependencyInjection;

use _PhpScoper78e1a27e740b\Symfony\Component\DependencyInjection\Argument\IteratorArgument;
use _PhpScoper78e1a27e740b\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use _PhpScoper78e1a27e740b\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoper78e1a27e740b\Symfony\Component\DependencyInjection\ContainerInterface;
use _PhpScoper78e1a27e740b\Symfony\Component\DependencyInjection\Exception\RuntimeException;
use _PhpScoper78e1a27e740b\Symfony\Component\DependencyInjection\Reference;
/**
 * @author Alexander M. Turek <me@derrabus.de>
 */
class ResettableServicePass implements CompilerPassInterface
{
    private $tagName;
    public function __construct(string $tagName = 'kernel.reset')
    {
        $this->tagName = $tagName;
    }
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('services_resetter')) {
            return;
        }
        $services = $methods = [];
        foreach ($container->findTaggedServiceIds($this->tagName, \true) as $id => $tags) {
            $services[$id] = new Reference($id, ContainerInterface::IGNORE_ON_UNINITIALIZED_REFERENCE);
            foreach ($tags as $attributes) {
                if (!isset($attributes['method'])) {
                    throw new RuntimeException(\sprintf('Tag "%s" requires the "method" attribute to be set.', $this->tagName));
                }
                if (!isset($methods[$id])) {
                    $methods[$id] = [];
                }
                $methods[$id][] = $attributes['method'];
            }
        }
        if (!$services) {
            $container->removeAlias('services_resetter');
            $container->removeDefinition('services_resetter');
            return;
        }
        $container->findDefinition('services_resetter')->setArgument(0, new IteratorArgument($services))->setArgument(1, $methods);
    }
}
