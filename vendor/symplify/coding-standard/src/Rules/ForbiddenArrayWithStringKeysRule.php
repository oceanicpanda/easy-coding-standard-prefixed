<?php

declare (strict_types=1);
namespace Symplify\CodingStandard\Rules;

use _PhpScoper3d04c8135695\Nette\Utils\Strings;
use _PhpScoper3d04c8135695\PhpParser\Node;
use _PhpScoper3d04c8135695\PhpParser\Node\Expr\Array_;
use _PhpScoper3d04c8135695\PhpParser\Node\Expr\ArrayItem;
use _PhpScoper3d04c8135695\PhpParser\Node\Expr\FuncCall;
use _PhpScoper3d04c8135695\PhpParser\Node\Expr\MethodCall;
use _PhpScoper3d04c8135695\PhpParser\Node\Expr\New_;
use _PhpScoper3d04c8135695\PhpParser\Node\Expr\StaticCall;
use _PhpScoper3d04c8135695\PhpParser\Node\Scalar\String_;
use _PhpScoper3d04c8135695\PhpParser\Node\Stmt\ClassConst;
use _PhpScoper3d04c8135695\PHPStan\Analyser\Scope;
use _PhpScoper3d04c8135695\PHPStan\Type\ArrayType;
use Symplify\CodingStandard\PHPStan\ParentGuard\ParentMethodReturnTypeResolver;
use Symplify\CodingStandard\ValueObject\MethodName;
use Symplify\CodingStandard\ValueObject\PHPStanAttributeKey;
/**
 * @see \Symplify\CodingStandard\Tests\Rules\ForbiddenArrayWithStringKeysRule\ForbiddenArrayWithStringKeysRuleTest
 */
final class ForbiddenArrayWithStringKeysRule extends \Symplify\CodingStandard\Rules\AbstractSymplifyRule
{
    /**
     * @var string
     */
    public const ERROR_MESSAGE = 'Array with keys is not allowed. Use value object to pass data instead';
    /**
     * @var string
     * @see https://regex101.com/r/ddj4mB/2
     */
    private const TEST_FILE_REGEX = '#(Test|TestCase)\\.php$#';
    /**
     * @var ParentMethodReturnTypeResolver
     */
    private $parentMethodReturnTypeResolver;
    public function __construct(\Symplify\CodingStandard\PHPStan\ParentGuard\ParentMethodReturnTypeResolver $parentMethodReturnTypeResolver)
    {
        $this->parentMethodReturnTypeResolver = $parentMethodReturnTypeResolver;
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper3d04c8135695\PhpParser\Node\Expr\Array_::class];
    }
    /**
     * @param Array_ $node
     * @return string[]
     */
    public function process(\_PhpScoper3d04c8135695\PhpParser\Node $node, \_PhpScoper3d04c8135695\PHPStan\Analyser\Scope $scope) : array
    {
        if ($this->shouldSkipArray($node, $scope)) {
            return [];
        }
        if (!$this->isArrayWithStringKey($node)) {
            return [];
        }
        // is return array required by parent
        $parentMethodReturnType = $this->parentMethodReturnTypeResolver->resolve($scope);
        if ($parentMethodReturnType instanceof \_PhpScoper3d04c8135695\PHPStan\Type\ArrayType) {
            return [];
        }
        return [self::ERROR_MESSAGE];
    }
    private function shouldSkipArray(\_PhpScoper3d04c8135695\PhpParser\Node\Expr\Array_ $array, \_PhpScoper3d04c8135695\PHPStan\Analyser\Scope $scope) : bool
    {
        if (\_PhpScoper3d04c8135695\Nette\Utils\Strings::match($scope->getFile(), self::TEST_FILE_REGEX)) {
            return \true;
        }
        // skip examples in Rector::getDefinition() method
        if (\in_array($scope->getFunctionName(), ['getDefinition', \Symplify\CodingStandard\ValueObject\MethodName::CONSTRUCTOR], \true)) {
            return \true;
        }
        return $this->isPartOfClassConstOrNew($array);
    }
    private function isPartOfClassConstOrNew(\_PhpScoper3d04c8135695\PhpParser\Node $currentNode) : bool
    {
        while ($currentNode = $currentNode->getAttribute(\Symplify\CodingStandard\ValueObject\PHPStanAttributeKey::PARENT)) {
            // constants can have default values
            if ($currentNode instanceof \_PhpScoper3d04c8135695\PhpParser\Node\Stmt\ClassConst) {
                return \true;
            }
            // the array with string keys is required by the object parameters
            if ($currentNode instanceof \_PhpScoper3d04c8135695\PhpParser\Node\Expr\New_) {
                return \true;
            }
            if ($currentNode instanceof \_PhpScoper3d04c8135695\PhpParser\Node\Expr\MethodCall) {
                return \true;
            }
            if ($currentNode instanceof \_PhpScoper3d04c8135695\PhpParser\Node\Expr\StaticCall) {
                return \true;
            }
            if ($currentNode instanceof \_PhpScoper3d04c8135695\PhpParser\Node\Expr\FuncCall) {
                return \true;
            }
        }
        return \false;
    }
    private function isArrayWithStringKey(\_PhpScoper3d04c8135695\PhpParser\Node\Expr\Array_ $array) : bool
    {
        foreach ($array->items as $arrayItem) {
            if ($arrayItem === null) {
                continue;
            }
            /** @var ArrayItem $arrayItem */
            if ($arrayItem->key === null) {
                continue;
            }
            if (!$arrayItem->key instanceof \_PhpScoper3d04c8135695\PhpParser\Node\Scalar\String_) {
                continue;
            }
            return \true;
        }
        return \false;
    }
}
