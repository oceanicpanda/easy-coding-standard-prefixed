<?php

declare (strict_types=1);
namespace _PhpScoperc753ccca5a0c;

use _PhpScoperc753ccca5a0c\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperc753ccca5a0c\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/another-one.php');
};
