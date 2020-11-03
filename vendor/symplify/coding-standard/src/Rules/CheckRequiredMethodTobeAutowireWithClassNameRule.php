<?php

declare (strict_types=1);
namespace Symplify\CodingStandard\Rules;

use _PhpScoper3d04c8135695\Nette\Utils\Strings;
use _PhpScoper3d04c8135695\PhpParser\Node;
use _PhpScoper3d04c8135695\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper3d04c8135695\PHPStan\Analyser\Scope;
/**
 * @see \Symplify\CodingStandard\Tests\Rules\CheckRequiredMethodTobeAutowireWithClassNameRule\CheckRequiredMethodTobeAutowireWithClassNameRuleTest
 */
final class CheckRequiredMethodTobeAutowireWithClassNameRule extends \Symplify\CodingStandard\Rules\AbstractSymplifyRule
{
    /**
     * @var string
     */
    public const ERROR_MESSAGE = 'Method with @required need to be named "%s()"';
    /**
     * @var string
     * @see https://regex101.com/r/gn2P0C/1
     */
    private const REQUIRED_DOCBLOCK_REGEX = '#\\*\\s+@required\\n?#';
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
        $docComment = $node->getDocComment();
        if ($docComment === null) {
            return [];
        }
        if (!\_PhpScoper3d04c8135695\Nette\Utils\Strings::match($docComment->getText(), self::REQUIRED_DOCBLOCK_REGEX)) {
            return [];
        }
        $shortClassName = $this->getShortClassName($scope);
        if ($shortClassName === null) {
            return [];
        }
        $requriedMethodName = 'autowire' . $shortClassName;
        $currentMethodName = (string) $node->name;
        if ($currentMethodName === $requriedMethodName) {
            return [];
        }
        $errorMessage = \sprintf(self::ERROR_MESSAGE, $requriedMethodName);
        return [$errorMessage];
    }
}
