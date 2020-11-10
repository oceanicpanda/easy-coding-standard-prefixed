<?php

declare (strict_types=1);
namespace _PhpScoper470d6df94ac0\Migrify\PhpConfigPrinter\DependencyInjection\Extension;

use _PhpScoper470d6df94ac0\Symfony\Component\Config\FileLocator;
use _PhpScoper470d6df94ac0\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoper470d6df94ac0\Symfony\Component\DependencyInjection\Extension\Extension;
use _PhpScoper470d6df94ac0\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
final class PhpConfigPrinterExtension extends \_PhpScoper470d6df94ac0\Symfony\Component\DependencyInjection\Extension\Extension
{
    public function load(array $configs, \_PhpScoper470d6df94ac0\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder) : void
    {
        // needed for parameter shifting of sniff/fixer params
        $phpFileLoader = new \_PhpScoper470d6df94ac0\Symfony\Component\DependencyInjection\Loader\PhpFileLoader($containerBuilder, new \_PhpScoper470d6df94ac0\Symfony\Component\Config\FileLocator(__DIR__ . '/../../../config'));
        $phpFileLoader->load('config.php');
    }
}
