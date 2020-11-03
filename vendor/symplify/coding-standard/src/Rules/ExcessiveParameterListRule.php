<?php

declare (strict_types=1);
namespace Symplify\CodingStandard\Rules;

use _PhpScoper3d04c8135695\PhpParser\Node;
use _PhpScoper3d04c8135695\PhpParser\Node\Expr\ArrowFunction;
use _PhpScoper3d04c8135695\PhpParser\Node\Expr\Closure;
use _PhpScoper3d04c8135695\PhpParser\Node\FunctionLike;
use _PhpScoper3d04c8135695\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper3d04c8135695\PhpParser\Node\Stmt\Function_;
use _PhpScoper3d04c8135695\PHPStan\Analyser\Scope;
/**
 * @see \Symplify\CodingStandard\Tests\Rules\ExcessiveParameterListRule\ExcessiveParameterListRuleTest
 */
final class ExcessiveParameterListRule extends \Symplify\CodingStandard\Rules\AbstractSymplifyRule
{
    /**
     * @var string
     */
    public const ERROR_MESSAGE = 'Method "%s()" is using too many parameters - %d. Make it under %d';
    /**
     * @var int
     */
    private $maxParameterCount;
    public function __construct(int $maxParameterCount = 10)
    {
        $this->maxParameterCount = $maxParameterCount;
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper3d04c8135695\PhpParser\Node\FunctionLike::class];
    }
    /**
     * @param FunctionLike $node
     * @return string[]
     */
    public function process(\_PhpScoper3d04c8135695\PhpParser\Node $node, \_PhpScoper3d04c8135695\PHPStan\Analyser\Scope $scope) : array
    {
        $currentParameterCount = \count((array) $node->getParams());
        if ($currentParameterCount <= $this->maxParameterCount) {
            return [];
        }
        $name = $this->resolveName($node);
        $message = \sprintf(self::ERROR_MESSAGE, $name, $currentParameterCount, $this->maxParameterCount);
        return [$message];
    }
    private function resolveName(\_PhpScoper3d04c8135695\PhpParser\Node\FunctionLike $functionLike) : string
    {
        if ($functionLike instanceof \_PhpScoper3d04c8135695\PhpParser\Node\Stmt\ClassMethod || $functionLike instanceof \_PhpScoper3d04c8135695\PhpParser\Node\Stmt\Function_) {
            return (string) $functionLike->name;
        }
        if ($functionLike instanceof \_PhpScoper3d04c8135695\PhpParser\Node\Expr\ArrowFunction) {
            return 'arrow function';
        }
        if ($functionLike instanceof \_PhpScoper3d04c8135695\PhpParser\Node\Expr\Closure) {
            return 'closure';
        }
        return 'unknown';
    }
}
