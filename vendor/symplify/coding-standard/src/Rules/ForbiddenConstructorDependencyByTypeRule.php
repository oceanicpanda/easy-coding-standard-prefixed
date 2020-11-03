<?php

declare (strict_types=1);
namespace Symplify\CodingStandard\Rules;

use _PhpScoper3d04c8135695\PhpParser\Node;
use _PhpScoper3d04c8135695\PhpParser\Node\Name;
use _PhpScoper3d04c8135695\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper3d04c8135695\PHPStan\Analyser\Scope;
/**
 * @see \Symplify\CodingStandard\Tests\Rules\ForbiddenConstructorDependencyByTypeRule\ForbiddenConstructorDependencyByTypeRuleTest
 */
final class ForbiddenConstructorDependencyByTypeRule extends \Symplify\CodingStandard\Rules\AbstractSymplifyRule
{
    /**
     * @var string
     */
    public const ERROR_MESSAGE = 'Object instance of %s is forbidden to be passed to constructor';
    /**
     * @var string[]
     */
    private $forbiddenTypes = [];
    /**
     * @param string[] $forbiddenTypes
     */
    public function __construct(array $forbiddenTypes = [])
    {
        $this->forbiddenTypes = $forbiddenTypes;
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper3d04c8135695\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     * @return string[]
     */
    public function process(\_PhpScoper3d04c8135695\PhpParser\Node $node, \_PhpScoper3d04c8135695\PHPStan\Analyser\Scope $scope) : array
    {
        if ($scope->getClassReflection() === null) {
            return [];
        }
        $methodName = (string) $node->name;
        if ($methodName !== '__construct') {
            return [];
        }
        $params = $node->params;
        foreach ($params as $param) {
            if (!$param->type instanceof \_PhpScoper3d04c8135695\PhpParser\Node\Name) {
                continue;
            }
            $paramType = $param->type->toString();
            $forbiddenType = $this->getForbiddenType($paramType);
            if ($forbiddenType === null) {
                continue;
            }
            return [\sprintf(self::ERROR_MESSAGE, $forbiddenType)];
        }
        return [];
    }
    private function getForbiddenType(string $paramType) : ?string
    {
        foreach ($this->forbiddenTypes as $forbiddenType) {
            if (\is_a($paramType, $forbiddenType, \true)) {
                return $forbiddenType;
            }
        }
        return null;
    }
}
