<?php

declare (strict_types=1);
namespace _PhpScoper08686b2277af;

use _PhpScoper08686b2277af\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper08686b2277af\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->autoconfigure()->public();
    $services->load('Symplify\\EasyCodingStandard\\Configuration\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Exception']);
};
