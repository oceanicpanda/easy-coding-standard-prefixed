<?php

declare (strict_types=1);
namespace _PhpScopere24d949bf310;

use PHP_CodeSniffer\Fixer;
use _PhpScopere24d949bf310\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere24d949bf310\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->autoconfigure()->public();
    $services->load('Symplify\\EasyCodingStandard\\SniffRunner\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Exception', __DIR__ . '/../src/ValueObject']);
    $services->set(\PHP_CodeSniffer\Fixer::class);
};
