<?php

declare (strict_types=1);
namespace _PhpScoper7145e5e87de5;

use _PhpScoper7145e5e87de5\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper7145e5e87de5\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/another-one.php');
};
