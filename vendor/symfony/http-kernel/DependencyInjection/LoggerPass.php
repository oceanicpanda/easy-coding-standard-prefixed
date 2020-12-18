<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperd8b12759ee0d\Symfony\Component\HttpKernel\DependencyInjection;

use _PhpScoperd8b12759ee0d\Psr\Log\LoggerInterface;
use _PhpScoperd8b12759ee0d\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use _PhpScoperd8b12759ee0d\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoperd8b12759ee0d\Symfony\Component\HttpKernel\Log\Logger;
/**
 * Registers the default logger if necessary.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class LoggerPass implements \_PhpScoperd8b12759ee0d\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(\_PhpScoperd8b12759ee0d\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        $container->setAlias(\_PhpScoperd8b12759ee0d\Psr\Log\LoggerInterface::class, 'logger')->setPublic(\false);
        if ($container->has('logger')) {
            return;
        }
        $container->register('logger', \_PhpScoperd8b12759ee0d\Symfony\Component\HttpKernel\Log\Logger::class)->setPublic(\false);
    }
}
