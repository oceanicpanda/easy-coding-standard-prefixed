<?php

declare (strict_types=1);
namespace _PhpScoper78e1a27e740b;

use PhpCsFixer\Fixer\Alias\BacktickToShellExecFixer;
use PhpCsFixer\Fixer\ArrayNotation\NormalizeIndexBraceFixer;
use PhpCsFixer\Fixer\CastNotation\NoUnsetCastFixer;
use PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer;
use PhpCsFixer\Fixer\Operator\TernaryToNullCoalescingFixer;
use PhpCsFixer\Fixer\Whitespace\HeredocIndentationFixer;
use _PhpScoper78e1a27e740b\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(BacktickToShellExecFixer::class);
    $services->set(HeredocIndentationFixer::class);
    $services->set(NoUnsetCastFixer::class);
    $services->set(NormalizeIndexBraceFixer::class);
    $services->set(TernaryToNullCoalescingFixer::class);
    $services->set(VisibilityRequiredFixer::class)->call('configure', [['elements' => ['const', 'method', 'property']]]);
};
