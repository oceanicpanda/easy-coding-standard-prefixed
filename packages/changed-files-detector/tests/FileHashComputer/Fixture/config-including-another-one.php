<?php

declare (strict_types=1);
namespace _PhpScoper7d3888cf4297;

use _PhpScoper7d3888cf4297\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper7d3888cf4297\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/another-one.php');
};
