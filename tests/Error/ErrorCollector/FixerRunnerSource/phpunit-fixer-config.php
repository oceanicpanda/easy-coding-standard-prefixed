<?php

declare (strict_types=1);
namespace _PhpScoper992f4af8b9e0;

use PhpCsFixer\Fixer\PhpUnit\PhpUnitStrictFixer;
use _PhpScoper992f4af8b9e0\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper992f4af8b9e0\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\PhpCsFixer\Fixer\PhpUnit\PhpUnitStrictFixer::class);
};
