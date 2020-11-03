<?php

declare (strict_types=1);
namespace Symplify\CodingStandard\Rules;

use _PhpScoper3d04c8135695\PhpParser\Node;
use _PhpScoper3d04c8135695\PhpParser\Node\Expr\Variable;
use _PhpScoper3d04c8135695\PhpParser\Node\Stmt;
use _PhpScoper3d04c8135695\PhpParser\Node\Stmt\Foreach_;
use _PhpScoper3d04c8135695\PhpParser\NodeFinder;
use _PhpScoper3d04c8135695\PHPStan\Analyser\Scope;
use Symplify\CodingStandard\ValueObject\PHPStanAttributeKey;
/**
 * @see \Symplify\CodingStandard\Tests\Rules\ForbiddenNestedForeachWithEmptyStatementRule\ForbiddenNestedForeachWithEmptyStatementRuleTest
 */
final class ForbiddenNestedForeachWithEmptyStatementRule extends \Symplify\CodingStandard\Rules\AbstractSymplifyRule
{
    /**
     * @var string
     */
    public const ERROR_MESSAGE = 'Nested foreach with empty statement is not allowed';
    /**
     * @var NodeFinder
     */
    private $nodeFinder;
    public function __construct(\_PhpScoper3d04c8135695\PhpParser\NodeFinder $nodeFinder)
    {
        $this->nodeFinder = $nodeFinder;
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper3d04c8135695\PhpParser\Node\Stmt\Foreach_::class];
    }
    /**
     * @param Foreach_ $node
     * @return string[]
     */
    public function process(\_PhpScoper3d04c8135695\PhpParser\Node $node, \_PhpScoper3d04c8135695\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$this->isNextForeachWithEmptyStatement($node)) {
            return [];
        }
        return [self::ERROR_MESSAGE];
    }
    public function isNextForeachWithEmptyStatement(\_PhpScoper3d04c8135695\PhpParser\Node\Stmt\Foreach_ $foreach) : bool
    {
        $stmts = $this->nodeFinder->findInstanceOf($foreach->stmts, \_PhpScoper3d04c8135695\PhpParser\Node\Stmt::class);
        if (!isset($stmts[0])) {
            return \false;
        }
        if (!$stmts[0] instanceof \_PhpScoper3d04c8135695\PhpParser\Node\Stmt\Foreach_) {
            return \false;
        }
        /** @var Variable $foreachVariable */
        $foreachVariable = $foreach->expr->getAttribute(\Symplify\CodingStandard\ValueObject\PHPStanAttributeKey::NEXT);
        /** @var Variable $nextForeachVariable */
        $nextForeachVariable = $stmts[0]->expr;
        return $foreachVariable->name === $nextForeachVariable->name;
    }
}
