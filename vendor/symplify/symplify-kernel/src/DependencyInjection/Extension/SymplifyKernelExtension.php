<?php

declare (strict_types=1);
namespace Symplify\SymplifyKernel\DependencyInjection\Extension;

use _PhpScoperc4ea0f0bd23f\Symfony\Component\Config\FileLocator;
use _PhpScoperc4ea0f0bd23f\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoperc4ea0f0bd23f\Symfony\Component\DependencyInjection\Extension\Extension;
use _PhpScoperc4ea0f0bd23f\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class SymplifyKernelExtension extends \_PhpScoperc4ea0f0bd23f\Symfony\Component\DependencyInjection\Extension\Extension
{
    public function load(array $configs, \_PhpScoperc4ea0f0bd23f\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $phpFileLoader = new \_PhpScoperc4ea0f0bd23f\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \_PhpScoperc4ea0f0bd23f\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('common-config.php');
    }
}
