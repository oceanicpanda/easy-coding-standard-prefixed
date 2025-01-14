<?php

declare (strict_types=1);
namespace _PhpScoper78e1a27e740b;

use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\ArrayNotation\NoTrailingCommaInSinglelineArrayFixer;
use PhpCsFixer\Fixer\ArrayNotation\NoWhitespaceBeforeCommaInArrayFixer;
use PhpCsFixer\Fixer\ArrayNotation\TrailingCommaInMultilineArrayFixer;
use PhpCsFixer\Fixer\ArrayNotation\TrimArraySpacesFixer;
use PhpCsFixer\Fixer\ArrayNotation\WhitespaceAfterCommaInArrayFixer;
use PhpCsFixer\Fixer\Whitespace\ArrayIndentationFixer;
use _PhpScoper78e1a27e740b\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\CodingStandard\Fixer\ArrayNotation\ArrayListItemNewlineFixer;
use Symplify\CodingStandard\Fixer\ArrayNotation\ArrayOpenerAndCloserNewlineFixer;
use Symplify\CodingStandard\Fixer\ArrayNotation\StandaloneLineInMultilineArrayFixer;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(NoWhitespaceBeforeCommaInArrayFixer::class);
    $services->set(ArrayOpenerAndCloserNewlineFixer::class);
    $services->set(ArrayIndentationFixer::class);
    $services->set(TrimArraySpacesFixer::class);
    $services->set(WhitespaceAfterCommaInArrayFixer::class);
    $services->set(ArrayListItemNewlineFixer::class);
    $services->set(StandaloneLineInMultilineArrayFixer::class);
    // commas
    $services->set(TrailingCommaInMultilineArrayFixer::class);
    $services->set(NoTrailingCommaInSinglelineArrayFixer::class);
    $services->set(ArraySyntaxFixer::class)->call('configure', [['syntax' => 'short']]);
};
