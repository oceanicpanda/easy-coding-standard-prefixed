<?php

declare (strict_types=1);
namespace Symplify\SymplifyKernel\DependencyInjection\CompilerPass;

use _PhpScoperd79d87c3336e\Symfony\Component\Console\Application;
use _PhpScoperd79d87c3336e\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use _PhpScoperd79d87c3336e\Symfony\Component\DependencyInjection\ContainerBuilder;
final class MakeConsoleApplicationPublicAliasCompilerPass implements \_PhpScoperd79d87c3336e\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    public function process(\_PhpScoperd79d87c3336e\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $consoleApplicationClass = $this->resolveConsoleApplicationClass($containerBuilder);
        if ($consoleApplicationClass === null) {
            return;
        }
        // add console application alias
        if ($consoleApplicationClass === \_PhpScoperd79d87c3336e\Symfony\Component\Console\Application::class) {
            return;
        }
        $containerBuilder->setAlias(\_PhpScoperd79d87c3336e\Symfony\Component\Console\Application::class, $consoleApplicationClass)->setPublic(\true);
    }
    private function resolveConsoleApplicationClass(\_PhpScoperd79d87c3336e\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : ?string
    {
        foreach ($containerBuilder->getDefinitions() as $definition) {
            if (!\is_a((string) $definition->getClass(), \_PhpScoperd79d87c3336e\Symfony\Component\Console\Application::class, \true)) {
                continue;
            }
            return $definition->getClass();
        }
        return null;
    }
}
