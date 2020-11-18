<?php

declare (strict_types=1);
namespace _PhpScoperf77bffce0320;

use PhpCsFixer\Fixer\Alias\EregToPregFixer;
use PhpCsFixer\Fixer\Alias\NoAliasFunctionsFixer;
use PhpCsFixer\Fixer\Alias\SetTypeToCastFixer;
use PhpCsFixer\Fixer\Basic\NonPrintableCharacterFixer;
use PhpCsFixer\Fixer\Basic\Psr4Fixer;
use PhpCsFixer\Fixer\CastNotation\ModernizeTypesCastingFixer;
use PhpCsFixer\Fixer\ClassNotation\NoUnneededFinalMethodFixer;
use PhpCsFixer\Fixer\ClassNotation\SelfAccessorFixer;
use PhpCsFixer\Fixer\ConstantNotation\NativeConstantInvocationFixer;
use PhpCsFixer\Fixer\FunctionNotation\FopenFlagOrderFixer;
use PhpCsFixer\Fixer\FunctionNotation\FopenFlagsFixer;
use PhpCsFixer\Fixer\FunctionNotation\ImplodeCallFixer;
use PhpCsFixer\Fixer\FunctionNotation\NativeFunctionInvocationFixer;
use PhpCsFixer\Fixer\LanguageConstruct\DirConstantFixer;
use PhpCsFixer\Fixer\LanguageConstruct\ErrorSuppressionFixer;
use PhpCsFixer\Fixer\LanguageConstruct\FunctionToConstantFixer;
use PhpCsFixer\Fixer\LanguageConstruct\IsNullFixer;
use PhpCsFixer\Fixer\Naming\NoHomoglyphNamesFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitConstructFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitMockShortWillReturnFixer;
use _PhpScoperf77bffce0320\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperf77bffce0320\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\PhpCsFixer\Fixer\LanguageConstruct\DirConstantFixer::class);
    $services->set(\PhpCsFixer\Fixer\Alias\EregToPregFixer::class);
    $services->set(\PhpCsFixer\Fixer\LanguageConstruct\ErrorSuppressionFixer::class);
    $services->set(\PhpCsFixer\Fixer\FunctionNotation\FopenFlagOrderFixer::class);
    $services->set(\PhpCsFixer\Fixer\FunctionNotation\FopenFlagsFixer::class)->call('configure', [['b_mode' => \false]]);
    $services->set(\PhpCsFixer\Fixer\LanguageConstruct\FunctionToConstantFixer::class)->call('configure', [['functions' => ['get_called_class', 'get_class', 'get_class_this', 'php_sapi_name', 'phpversion', 'pi']]]);
    $services->set(\PhpCsFixer\Fixer\FunctionNotation\ImplodeCallFixer::class);
    $services->set(\PhpCsFixer\Fixer\LanguageConstruct\IsNullFixer::class);
    $services->set(\PhpCsFixer\Fixer\CastNotation\ModernizeTypesCastingFixer::class);
    $services->set(\PhpCsFixer\Fixer\ConstantNotation\NativeConstantInvocationFixer::class)->call('configure', [['fix_built_in' => \false, 'include' => ['DIRECTORY_SEPARATOR', 'PHP_SAPI', 'PHP_VERSION_ID'], 'scope' => 'namespaced']]);
    $services->set(\PhpCsFixer\Fixer\FunctionNotation\NativeFunctionInvocationFixer::class)->call('configure', [['include' => [\PhpCsFixer\Fixer\FunctionNotation\NativeFunctionInvocationFixer::SET_COMPILER_OPTIMIZED], 'scope' => 'namespaced', 'strict' => \true]]);
    $services->set(\PhpCsFixer\Fixer\Alias\NoAliasFunctionsFixer::class);
    $services->set(\PhpCsFixer\Fixer\Naming\NoHomoglyphNamesFixer::class);
    $services->set(\PhpCsFixer\Fixer\ClassNotation\NoUnneededFinalMethodFixer::class);
    $services->set(\PhpCsFixer\Fixer\Basic\NonPrintableCharacterFixer::class);
    $services->set(\PhpCsFixer\Fixer\PhpUnit\PhpUnitConstructFixer::class);
    $services->set(\PhpCsFixer\Fixer\PhpUnit\PhpUnitMockShortWillReturnFixer::class);
    $services->set(\PhpCsFixer\Fixer\Basic\Psr4Fixer::class);
    $services->set(\PhpCsFixer\Fixer\ClassNotation\SelfAccessorFixer::class);
    $services->set(\PhpCsFixer\Fixer\Alias\SetTypeToCastFixer::class);
};
