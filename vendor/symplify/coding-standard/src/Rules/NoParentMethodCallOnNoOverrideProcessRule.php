<?php

declare (strict_types=1);
namespace Symplify\CodingStandard\Rules;

use _PhpScoper3d04c8135695\PhpParser\Node;
use _PhpScoper3d04c8135695\PhpParser\Node\Expr\StaticCall;
use _PhpScoper3d04c8135695\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper3d04c8135695\PhpParser\Node\Stmt\Expression;
use _PhpScoper3d04c8135695\PHPStan\Analyser\Scope;
use Symplify\CodingStandard\PhpParser\NodeNameResolver;
use Symplify\CodingStandard\PHPStan\NodeComparator;
/**
 * @see \Symplify\CodingStandard\Tests\Rules\NoParentMethodCallOnNoOverrideProcessRule\NoParentMethodCallOnNoOverrideProcessRuleTest
 */
final class NoParentMethodCallOnNoOverrideProcessRule extends \Symplify\CodingStandard\Rules\AbstractSymplifyRule
{
    /**
     * @var string
     */
    public const ERROR_MESSAGE = 'Do not call parent method if no override process';
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var NodeComparator
     */
    private $nodeComparator;
    public function __construct(\Symplify\CodingStandard\PhpParser\NodeNameResolver $nodeNameResolver, \Symplify\CodingStandard\PHPStan\NodeComparator $nodeComparator)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeComparator = $nodeComparator;
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
        $onlyNode = $this->resolveOnlyNode($node);
        if (!$onlyNode instanceof \_PhpScoper3d04c8135695\PhpParser\Node\Expr\StaticCall) {
            return [];
        }
        if (!$this->isParentSelfMethodStaticCall($onlyNode, $node)) {
            return [];
        }
        $methodCallArgs = (array) $onlyNode->args;
        $classMethodParams = (array) $node->params;
        if (!$this->nodeComparator->areArgsAndParamsSame($methodCallArgs, $classMethodParams)) {
            return [];
        }
        return [self::ERROR_MESSAGE];
    }
    private function isParentSelfMethodStaticCall(\_PhpScoper3d04c8135695\PhpParser\Node $node, \_PhpScoper3d04c8135695\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$node instanceof \_PhpScoper3d04c8135695\PhpParser\Node\Expr\StaticCall) {
            return \false;
        }
        if (!$this->nodeNameResolver->isName($node->class, 'parent')) {
            return \false;
        }
        return $this->nodeNameResolver->areNamesEquals($node->name, $classMethod->name);
    }
    private function resolveOnlyNode(\_PhpScoper3d04c8135695\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScoper3d04c8135695\PhpParser\Node
    {
        $stmts = (array) $classMethod->stmts;
        if (\count($stmts) !== 1) {
            return null;
        }
        $onlyStmt = $stmts[0];
        if (!$onlyStmt instanceof \_PhpScoper3d04c8135695\PhpParser\Node\Stmt\Expression) {
            return null;
        }
        return $onlyStmt->expr;
    }
}
