<?php

declare (strict_types=1);
namespace _PhpScoper80dbed43490f\PhpParser\Node\Expr;

use _PhpScoper80dbed43490f\PhpParser\Node\Expr;
class UnaryMinus extends \_PhpScoper80dbed43490f\PhpParser\Node\Expr
{
    /** @var Expr Expression */
    public $expr;
    /**
     * Constructs a unary minus node.
     *
     * @param Expr  $expr       Expression
     * @param array $attributes Additional attributes
     */
    public function __construct(\_PhpScoper80dbed43490f\PhpParser\Node\Expr $expr, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->expr = $expr;
    }
    public function getSubNodeNames() : array
    {
        return ['expr'];
    }
    public function getType() : string
    {
        return 'Expr_UnaryMinus';
    }
}
