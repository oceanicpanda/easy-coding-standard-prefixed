<?php

declare (strict_types=1);
namespace _PhpScopera061b8a47e36;

use SlevomatCodingStandard\Sniffs\Files\LineLengthSniff;
use _PhpScopera061b8a47e36\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopera061b8a47e36\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\SlevomatCodingStandard\Sniffs\Files\LineLengthSniff::class);
};
