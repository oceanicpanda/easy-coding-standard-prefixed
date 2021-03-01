<?php

declare (strict_types=1);
namespace _PhpScoper06c5fb6c14ed;

use _PhpScoper06c5fb6c14ed\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper06c5fb6c14ed\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->autoconfigure()->public();
    $services->load('Symplify\\EasyCodingStandard\\SnippetFormatter\\', __DIR__ . '/../src');
};
