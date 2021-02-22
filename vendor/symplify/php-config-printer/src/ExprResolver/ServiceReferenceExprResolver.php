<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\ExprResolver;

use _PhpScoper10b1b2c5ca55\PhpParser\Node\Arg;
use _PhpScoper10b1b2c5ca55\PhpParser\Node\Expr;
use _PhpScoper10b1b2c5ca55\PhpParser\Node\Expr\FuncCall;
use _PhpScoper10b1b2c5ca55\PhpParser\Node\Name\FullyQualified;
final class ServiceReferenceExprResolver
{
    /**
     * @var StringExprResolver
     */
    private $stringExprResolver;
    public function __construct(\Symplify\PhpConfigPrinter\ExprResolver\StringExprResolver $stringExprResolver)
    {
        $this->stringExprResolver = $stringExprResolver;
    }
    public function resolveServiceReferenceExpr(string $value, bool $skipServiceReference, string $functionName) : \_PhpScoper10b1b2c5ca55\PhpParser\Node\Expr
    {
        $value = \ltrim($value, '@');
        $expr = $this->stringExprResolver->resolve($value, $skipServiceReference, \false);
        if ($skipServiceReference) {
            return $expr;
        }
        $args = [new \_PhpScoper10b1b2c5ca55\PhpParser\Node\Arg($expr)];
        return new \_PhpScoper10b1b2c5ca55\PhpParser\Node\Expr\FuncCall(new \_PhpScoper10b1b2c5ca55\PhpParser\Node\Name\FullyQualified($functionName), $args);
    }
}
