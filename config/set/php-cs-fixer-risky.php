<?php

declare (strict_types=1);
namespace _PhpScoper0d0ee1ba46d4;

use PhpCsFixer\Fixer\Alias\EregToPregFixer;
use PhpCsFixer\Fixer\Alias\NoAliasFunctionsFixer;
use PhpCsFixer\Fixer\Alias\SetTypeToCastFixer;
use PhpCsFixer\Fixer\Basic\NonPrintableCharacterFixer;
use PhpCsFixer\Fixer\Basic\Psr4Fixer;
use PhpCsFixer\Fixer\CastNotation\ModernizeTypesCastingFixer;
use PhpCsFixer\Fixer\ClassNotation\FinalInternalClassFixer;
use PhpCsFixer\Fixer\ClassNotation\NoUnneededFinalMethodFixer;
use PhpCsFixer\Fixer\ClassNotation\SelfAccessorFixer;
use PhpCsFixer\Fixer\Comment\CommentToPhpdocFixer;
use PhpCsFixer\Fixer\ConstantNotation\NativeConstantInvocationFixer;
use PhpCsFixer\Fixer\FunctionNotation\FopenFlagOrderFixer;
use PhpCsFixer\Fixer\FunctionNotation\FopenFlagsFixer;
use PhpCsFixer\Fixer\FunctionNotation\ImplodeCallFixer;
use PhpCsFixer\Fixer\FunctionNotation\NativeFunctionInvocationFixer;
use PhpCsFixer\Fixer\FunctionNotation\NoUnreachableDefaultArgumentValueFixer;
use PhpCsFixer\Fixer\LanguageConstruct\DirConstantFixer;
use PhpCsFixer\Fixer\LanguageConstruct\ErrorSuppressionFixer;
use PhpCsFixer\Fixer\LanguageConstruct\FunctionToConstantFixer;
use PhpCsFixer\Fixer\LanguageConstruct\IsNullFixer;
use PhpCsFixer\Fixer\LanguageConstruct\NoUnsetOnPropertyFixer;
use PhpCsFixer\Fixer\Naming\NoHomoglyphNamesFixer;
use PhpCsFixer\Fixer\Operator\LogicalOperatorsFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitConstructFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitMockShortWillReturnFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitSetUpTearDownVisibilityFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitStrictFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitTestAnnotationFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitTestCaseStaticMethodCallsFixer;
use PhpCsFixer\Fixer\Strict\StrictComparisonFixer;
use PhpCsFixer\Fixer\Strict\StrictParamFixer;
use PhpCsFixer\Fixer\StringNotation\StringLineEndingFixer;
use _PhpScoper0d0ee1ba46d4\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0d0ee1ba46d4\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\PhpCsFixer\Fixer\Comment\CommentToPhpdocFixer::class);
    $services->set(\PhpCsFixer\Fixer\LanguageConstruct\DirConstantFixer::class);
    $services->set(\PhpCsFixer\Fixer\Alias\EregToPregFixer::class);
    $services->set(\PhpCsFixer\Fixer\LanguageConstruct\ErrorSuppressionFixer::class);
    $services->set(\PhpCsFixer\Fixer\ClassNotation\FinalInternalClassFixer::class);
    $services->set(\PhpCsFixer\Fixer\FunctionNotation\FopenFlagOrderFixer::class);
    $services->set(\PhpCsFixer\Fixer\FunctionNotation\FopenFlagsFixer::class)->call('configure', [['b_mode' => \false]]);
    $services->set(\PhpCsFixer\Fixer\LanguageConstruct\FunctionToConstantFixer::class)->call('configure', [['functions' => ['get_called_class', 'get_class', 'get_class_this', 'php_sapi_name', 'phpversion', 'pi']]]);
    $services->set(\PhpCsFixer\Fixer\FunctionNotation\ImplodeCallFixer::class);
    $services->set(\PhpCsFixer\Fixer\LanguageConstruct\IsNullFixer::class);
    $services->set(\PhpCsFixer\Fixer\Operator\LogicalOperatorsFixer::class);
    $services->set(\PhpCsFixer\Fixer\CastNotation\ModernizeTypesCastingFixer::class);
    $services->set(\PhpCsFixer\Fixer\ConstantNotation\NativeConstantInvocationFixer::class)->call('configure', [['fix_built_in' => \false, 'include' => ['DIRECTORY_SEPARATOR', 'PHP_SAPI', 'PHP_VERSION_ID'], 'scope' => 'namespaced']]);
    $services->set(\PhpCsFixer\Fixer\FunctionNotation\NativeFunctionInvocationFixer::class)->call('configure', [['include' => ['@compiler_optimized'], 'scope' => 'namespaced', 'strict' => \true]]);
    $services->set(\PhpCsFixer\Fixer\Alias\NoAliasFunctionsFixer::class);
    $services->set(\PhpCsFixer\Fixer\Naming\NoHomoglyphNamesFixer::class);
    $services->set(\PhpCsFixer\Fixer\ClassNotation\NoUnneededFinalMethodFixer::class);
    $services->set(\PhpCsFixer\Fixer\FunctionNotation\NoUnreachableDefaultArgumentValueFixer::class);
    $services->set(\PhpCsFixer\Fixer\LanguageConstruct\NoUnsetOnPropertyFixer::class);
    $services->set(\PhpCsFixer\Fixer\Basic\NonPrintableCharacterFixer::class);
    $services->set(\PhpCsFixer\Fixer\PhpUnit\PhpUnitConstructFixer::class);
    $services->set(\PhpCsFixer\Fixer\PhpUnit\PhpUnitMockShortWillReturnFixer::class);
    $services->set(\PhpCsFixer\Fixer\PhpUnit\PhpUnitSetUpTearDownVisibilityFixer::class);
    $services->set(\PhpCsFixer\Fixer\PhpUnit\PhpUnitStrictFixer::class);
    $services->set(\PhpCsFixer\Fixer\PhpUnit\PhpUnitTestAnnotationFixer::class);
    $services->set(\PhpCsFixer\Fixer\PhpUnit\PhpUnitTestCaseStaticMethodCallsFixer::class);
    $services->set(\PhpCsFixer\Fixer\Basic\Psr4Fixer::class);
    $services->set(\PhpCsFixer\Fixer\ClassNotation\SelfAccessorFixer::class);
    $services->set(\PhpCsFixer\Fixer\Alias\SetTypeToCastFixer::class);
    $services->set(\PhpCsFixer\Fixer\Strict\StrictComparisonFixer::class);
    $services->set(\PhpCsFixer\Fixer\Strict\StrictParamFixer::class);
    $services->set(\PhpCsFixer\Fixer\StringNotation\StringLineEndingFixer::class);
};