<?php

declare (strict_types=1);
namespace Symplify\CodingStandard\Rules;

use _PhpScoper3d04c8135695\PhpParser\Node;
use _PhpScoper3d04c8135695\PhpParser\Node\Expr\Array_;
use _PhpScoper3d04c8135695\PhpParser\Node\Expr\ArrayItem;
use _PhpScoper3d04c8135695\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper3d04c8135695\PHPStan\Analyser\Scope;
use _PhpScoper3d04c8135695\PHPStan\Reflection\Native\NativeParameterReflection;
use _PhpScoper3d04c8135695\PHPStan\Type\ObjectType;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
/**
 * @see \Symplify\CodingStandard\Tests\Rules\ForbiddenComplexArrayConfigInSetRule\ForbiddenComplexArrayConfigInSetRuleTest
 */
final class ForbiddenComplexArrayConfigInSetRule extends \Symplify\CodingStandard\Rules\AbstractSymplifyRule
{
    /**
     * @var string
     */
    public const ERROR_MESSAGE = 'For complex configuration use value object over array';
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper3d04c8135695\PhpParser\Node\Expr\ArrayItem::class];
    }
    /**
     * @param ArrayItem $node
     * @return string[]
     */
    public function process(\_PhpScoper3d04c8135695\PhpParser\Node $node, \_PhpScoper3d04c8135695\PHPStan\Analyser\Scope $scope) : array
    {
        // typical for configuration
        if (!$node->key instanceof \_PhpScoper3d04c8135695\PhpParser\Node\Expr\ClassConstFetch) {
            return [];
        }
        if (!$this->isInSymfonyPhpConfigClosure($scope)) {
            return [];
        }
        // simple → skip
        if (!$node->value instanceof \_PhpScoper3d04c8135695\PhpParser\Node\Expr\Array_) {
            return [];
        }
        $valueArray = $node->value;
        foreach ($valueArray->items as $nestedItem) {
            if (!$nestedItem instanceof \_PhpScoper3d04c8135695\PhpParser\Node\Expr\ArrayItem) {
                continue;
            }
            // way too complex
            if ($nestedItem->value instanceof \_PhpScoper3d04c8135695\PhpParser\Node\Expr\Array_) {
                return [self::ERROR_MESSAGE];
            }
        }
        return [];
    }
    private function isInSymfonyPhpConfigClosure(\_PhpScoper3d04c8135695\PHPStan\Analyser\Scope $scope) : bool
    {
        // we are in a closure
        if ($scope->getAnonymousFunctionReflection() === null) {
            return \false;
        }
        if (\count($scope->getAnonymousFunctionReflection()->getParameters()) !== 1) {
            return \false;
        }
        /** @var NativeParameterReflection $onlyParameter */
        $onlyParameter = $scope->getAnonymousFunctionReflection()->getParameters()[0];
        $onlyParameterType = $onlyParameter->getType();
        $containerConfiguratorObjectType = new \_PhpScoper3d04c8135695\PHPStan\Type\ObjectType(\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator::class);
        return $onlyParameterType->isSuperTypeOf($containerConfiguratorObjectType)->yes();
    }
}
