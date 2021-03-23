<?php

declare (strict_types=1);
namespace Symplify\EasyCodingStandard\DependencyInjection;

use _PhpScoperc7096eb2567d\Symfony\Component\Config\FileLocator as SimpleFileLocator;
use _PhpScoperc7096eb2567d\Symfony\Component\Config\Loader\DelegatingLoader;
use _PhpScoperc7096eb2567d\Symfony\Component\Config\Loader\GlobFileLoader;
use _PhpScoperc7096eb2567d\Symfony\Component\Config\Loader\LoaderResolver;
use _PhpScoperc7096eb2567d\Symfony\Component\DependencyInjection\ContainerBuilder;
use _PhpScoperc7096eb2567d\Symfony\Component\HttpKernel\Config\FileLocator;
use _PhpScoperc7096eb2567d\Symfony\Component\HttpKernel\KernelInterface;
use Symplify\PackageBuilder\DependencyInjection\FileLoader\ParameterMergingPhpFileLoader;
final class DelegatingLoaderFactory
{
    public function createFromContainerBuilderAndKernel(\_PhpScoperc7096eb2567d\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, \_PhpScoperc7096eb2567d\Symfony\Component\HttpKernel\KernelInterface $kernel) : \_PhpScoperc7096eb2567d\Symfony\Component\Config\Loader\DelegatingLoader
    {
        $kernelFileLocator = new \_PhpScoperc7096eb2567d\Symfony\Component\HttpKernel\Config\FileLocator($kernel);
        return $this->createFromContainerBuilderAndFileLocator($containerBuilder, $kernelFileLocator);
    }
    /**
     * For tests
     */
    public function createContainerBuilderAndConfig(\_PhpScoperc7096eb2567d\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $config) : \_PhpScoperc7096eb2567d\Symfony\Component\Config\Loader\DelegatingLoader
    {
        $directory = \dirname($config);
        $fileLocator = new \_PhpScoperc7096eb2567d\Symfony\Component\Config\FileLocator($directory);
        return $this->createFromContainerBuilderAndFileLocator($containerBuilder, $fileLocator);
    }
    private function createFromContainerBuilderAndFileLocator(\_PhpScoperc7096eb2567d\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, \_PhpScoperc7096eb2567d\Symfony\Component\Config\FileLocator $simpleFileLocator) : \_PhpScoperc7096eb2567d\Symfony\Component\Config\Loader\DelegatingLoader
    {
        $loaders = [new \_PhpScoperc7096eb2567d\Symfony\Component\Config\Loader\GlobFileLoader($simpleFileLocator), new \Symplify\PackageBuilder\DependencyInjection\FileLoader\ParameterMergingPhpFileLoader($containerBuilder, $simpleFileLocator)];
        $loaderResolver = new \_PhpScoperc7096eb2567d\Symfony\Component\Config\Loader\LoaderResolver($loaders);
        return new \_PhpScoperc7096eb2567d\Symfony\Component\Config\Loader\DelegatingLoader($loaderResolver);
    }
}
