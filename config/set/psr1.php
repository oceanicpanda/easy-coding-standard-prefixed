<?php

declare (strict_types=1);
namespace _PhpScoperfb2c402b972b;

use PhpCsFixer\Fixer\Basic\EncodingFixer;
use PhpCsFixer\Fixer\PhpTag\FullOpeningTagFixer;
use _PhpScoperfb2c402b972b\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperfb2c402b972b\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\PhpCsFixer\Fixer\Basic\EncodingFixer::class);
    $services->set(\PhpCsFixer\Fixer\PhpTag\FullOpeningTagFixer::class);
};
