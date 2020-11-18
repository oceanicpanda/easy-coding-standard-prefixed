<?php

declare (strict_types=1);
namespace _PhpScoperf77bffce0320\Migrify\MigrifyKernel\Bundle;

use _PhpScoperf77bffce0320\Migrify\MigrifyKernel\DependencyInjection\CompilerPass\PrepareConsoleApplicationCompilerPass;
use _PhpScoperf77bffce0320\Migrify\MigrifyKernel\DependencyInjection\Extension\MigrifyKernelExtension;
use _PhpScoperf77bffce0320\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoperf77bffce0320\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use _PhpScoperf77bffce0320\Symfony\Component\HttpKernel\Bundle\Bundle;
use Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
final class MigrifyKernelBundle extends \_PhpScoperf77bffce0320\Symfony\Component\HttpKernel\Bundle\Bundle
{
    public function build(\_PhpScoperf77bffce0320\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $containerBuilder->addCompilerPass(new \Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass());
        $containerBuilder->addCompilerPass(new \_PhpScoperf77bffce0320\Migrify\MigrifyKernel\DependencyInjection\CompilerPass\PrepareConsoleApplicationCompilerPass());
    }
    protected function createContainerExtension() : ?\_PhpScoperf77bffce0320\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \_PhpScoperf77bffce0320\Migrify\MigrifyKernel\DependencyInjection\Extension\MigrifyKernelExtension();
    }
}
