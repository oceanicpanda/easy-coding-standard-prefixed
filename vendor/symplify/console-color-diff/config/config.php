<?php

declare (strict_types=1);
namespace _PhpScoper514703a076a2;

use _PhpScoper514703a076a2\SebastianBergmann\Diff\Differ;
use _PhpScoper514703a076a2\Symfony\Component\Console\Style\SymfonyStyle;
use _PhpScoper514703a076a2\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use Symplify\PackageBuilder\Reflection\PrivatesAccessor;
use function _PhpScoper514703a076a2\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\ConsoleColorDiff\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Bundle']);
    $services->set(Differ::class);
    $services->set(SymfonyStyleFactory::class);
    $services->set(SymfonyStyle::class)->factory([service(SymfonyStyleFactory::class), 'create']);
    $services->set(PrivatesAccessor::class);
};
