<?php

declare (strict_types=1);
namespace _PhpScoper255a4eaff575;

use _PhpScoper255a4eaff575\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper255a4eaff575\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set('one', 'configuration-1');
};
