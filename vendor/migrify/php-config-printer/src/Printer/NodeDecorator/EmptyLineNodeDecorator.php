<?php

declare (strict_types=1);
namespace _PhpScoper70072c07b02b\Migrify\PhpConfigPrinter\Printer\NodeDecorator;

use _PhpScoper70072c07b02b\Migrify\MigrifyKernel\Exception\ShouldNotHappenException;
use _PhpScoper70072c07b02b\PhpParser\Node;
use _PhpScoper70072c07b02b\PhpParser\Node\Expr\Assign;
use _PhpScoper70072c07b02b\PhpParser\Node\Expr\Closure;
use _PhpScoper70072c07b02b\PhpParser\Node\Expr\MethodCall;
use _PhpScoper70072c07b02b\PhpParser\Node\Stmt;
use _PhpScoper70072c07b02b\PhpParser\Node\Stmt\Expression;
use _PhpScoper70072c07b02b\PhpParser\Node\Stmt\Nop;
use _PhpScoper70072c07b02b\PhpParser\NodeFinder;
final class EmptyLineNodeDecorator
{
    /**
     * @var NodeFinder
     */
    private $nodeFinder;
    public function __construct(\_PhpScoper70072c07b02b\PhpParser\NodeFinder $nodeFinder)
    {
        $this->nodeFinder = $nodeFinder;
    }
    /**
     * @param Node[] $stmts
     */
    public function decorate(array $stmts) : void
    {
        /** @var Closure|null $closure */
        $closure = $this->nodeFinder->findFirstInstanceOf($stmts, \_PhpScoper70072c07b02b\PhpParser\Node\Expr\Closure::class);
        if ($closure === null) {
            throw new \_PhpScoper70072c07b02b\Migrify\MigrifyKernel\Exception\ShouldNotHappenException();
        }
        $newStmts = [];
        foreach ($closure->stmts as $key => $closureStmt) {
            if ($this->shouldAddEmptyLineBeforeStatement($key, $closureStmt)) {
                $newStmts[] = new \_PhpScoper70072c07b02b\PhpParser\Node\Stmt\Nop();
            }
            $newStmts[] = $closureStmt;
        }
        $closure->stmts = $newStmts;
    }
    private function shouldAddEmptyLineBeforeStatement(int $key, \_PhpScoper70072c07b02b\PhpParser\Node\Stmt $stmt) : bool
    {
        // do not add space before first item
        if ($key === 0) {
            return \false;
        }
        if (!$stmt instanceof \_PhpScoper70072c07b02b\PhpParser\Node\Stmt\Expression) {
            return \false;
        }
        $expr = $stmt->expr;
        if ($expr instanceof \_PhpScoper70072c07b02b\PhpParser\Node\Expr\Assign) {
            return \true;
        }
        return $expr instanceof \_PhpScoper70072c07b02b\PhpParser\Node\Expr\MethodCall;
    }
}
