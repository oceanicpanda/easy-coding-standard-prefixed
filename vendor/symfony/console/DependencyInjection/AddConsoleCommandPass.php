<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperb6361033cf41\Symfony\Component\Console\DependencyInjection;

use _PhpScoperb6361033cf41\Symfony\Component\Console\Command\Command;
use _PhpScoperb6361033cf41\Symfony\Component\Console\CommandLoader\ContainerCommandLoader;
use _PhpScoperb6361033cf41\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use _PhpScoperb6361033cf41\Symfony\Component\DependencyInjection\Compiler\ServiceLocatorTagPass;
use _PhpScoperb6361033cf41\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoperb6361033cf41\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use _PhpScoperb6361033cf41\Symfony\Component\DependencyInjection\TypedReference;
/**
 * Registers console commands.
 *
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
 */
class AddConsoleCommandPass implements \_PhpScoperb6361033cf41\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    private $commandLoaderServiceId;
    private $commandTag;
    private $noPreloadTag;
    private $privateTagName;
    public function __construct(string $commandLoaderServiceId = 'console.command_loader', string $commandTag = 'console.command', string $noPreloadTag = 'container.no_preload', string $privateTagName = 'container.private')
    {
        $this->commandLoaderServiceId = $commandLoaderServiceId;
        $this->commandTag = $commandTag;
        $this->noPreloadTag = $noPreloadTag;
        $this->privateTagName = $privateTagName;
    }
    public function process(\_PhpScoperb6361033cf41\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        $commandServices = $container->findTaggedServiceIds($this->commandTag, \true);
        $lazyCommandMap = [];
        $lazyCommandRefs = [];
        $serviceIds = [];
        foreach ($commandServices as $id => $tags) {
            $definition = $container->getDefinition($id);
            $definition->addTag($this->noPreloadTag);
            $class = $container->getParameterBag()->resolveValue($definition->getClass());
            if (isset($tags[0]['command'])) {
                $commandName = $tags[0]['command'];
            } else {
                if (!($r = $container->getReflectionClass($class))) {
                    throw new \_PhpScoperb6361033cf41\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException(\sprintf('Class "%s" used for service "%s" cannot be found.', $class, $id));
                }
                if (!$r->isSubclassOf(\_PhpScoperb6361033cf41\Symfony\Component\Console\Command\Command::class)) {
                    throw new \_PhpScoperb6361033cf41\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException(\sprintf('The service "%s" tagged "%s" must be a subclass of "%s".', $id, $this->commandTag, \_PhpScoperb6361033cf41\Symfony\Component\Console\Command\Command::class));
                }
                $commandName = $class::getDefaultName();
            }
            if (null === $commandName) {
                if (!$definition->isPublic() || $definition->isPrivate() || $definition->hasTag($this->privateTagName)) {
                    $commandId = 'console.command.public_alias.' . $id;
                    $container->setAlias($commandId, $id)->setPublic(\true);
                    $id = $commandId;
                }
                $serviceIds[] = $id;
                continue;
            }
            unset($tags[0]);
            $lazyCommandMap[$commandName] = $id;
            $lazyCommandRefs[$id] = new \_PhpScoperb6361033cf41\Symfony\Component\DependencyInjection\TypedReference($id, $class);
            $aliases = [];
            foreach ($tags as $tag) {
                if (isset($tag['command'])) {
                    $aliases[] = $tag['command'];
                    $lazyCommandMap[$tag['command']] = $id;
                }
            }
            $definition->addMethodCall('setName', [$commandName]);
            if ($aliases) {
                $definition->addMethodCall('setAliases', [$aliases]);
            }
        }
        $container->register($this->commandLoaderServiceId, \_PhpScoperb6361033cf41\Symfony\Component\Console\CommandLoader\ContainerCommandLoader::class)->setPublic(\true)->addTag($this->noPreloadTag)->setArguments([\_PhpScoperb6361033cf41\Symfony\Component\DependencyInjection\Compiler\ServiceLocatorTagPass::register($container, $lazyCommandRefs), $lazyCommandMap]);
        $container->setParameter('console.command.ids', $serviceIds);
    }
}
