<?php

declare (strict_types=1);
namespace _PhpScoper269dc521b0fa;

use _PhpScoper269dc521b0fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper269dc521b0fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->autoconfigure()->public();
    $services->load('Symplify\\EasyCodingStandard\\SnippetFormatter\\', __DIR__ . '/../src');
};
