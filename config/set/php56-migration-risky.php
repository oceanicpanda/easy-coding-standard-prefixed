<?php

declare (strict_types=1);
namespace _PhpScoper64a921a5401b;

use PhpCsFixer\Fixer\Alias\PowToExponentiationFixer;
use _PhpScoper64a921a5401b\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper64a921a5401b\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\PhpCsFixer\Fixer\Alias\PowToExponentiationFixer::class);
};
