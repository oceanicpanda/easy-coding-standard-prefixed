<?php

declare (strict_types=1);
namespace _PhpScopera061b8a47e36;

use _PhpScopera061b8a47e36\PhpParser\BuilderFactory;
use _PhpScopera061b8a47e36\PhpParser\NodeFinder;
use _PhpScopera061b8a47e36\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopera061b8a47e36\Symfony\Component\Yaml\Parser;
use Symplify\PackageBuilder\Parameter\ParameterProvider;
return static function (\_PhpScopera061b8a47e36\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Symplify\\PhpConfigPrinter\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/HttpKernel', __DIR__ . '/../src/Dummy', __DIR__ . '/../src/Bundle']);
    $services->set(\_PhpScopera061b8a47e36\PhpParser\NodeFinder::class);
    $services->set(\_PhpScopera061b8a47e36\Symfony\Component\Yaml\Parser::class);
    $services->set(\_PhpScopera061b8a47e36\PhpParser\BuilderFactory::class);
    $services->set(\Symplify\PackageBuilder\Parameter\ParameterProvider::class);
};
