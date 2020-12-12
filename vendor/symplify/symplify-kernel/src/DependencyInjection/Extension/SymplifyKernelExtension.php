<?php

declare (strict_types=1);
namespace Symplify\SymplifyKernel\DependencyInjection\Extension;

use _PhpScoperef870243cfdb\Symfony\Component\Config\FileLocator;
use _PhpScoperef870243cfdb\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoperef870243cfdb\Symfony\Component\DependencyInjection\Extension\Extension;
use _PhpScoperef870243cfdb\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class SymplifyKernelExtension extends \_PhpScoperef870243cfdb\Symfony\Component\DependencyInjection\Extension\Extension
{
    public function load(array $configs, \_PhpScoperef870243cfdb\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        $phpFileLoader = new \_PhpScoperef870243cfdb\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \_PhpScoperef870243cfdb\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('common-config.php');
    }
}
