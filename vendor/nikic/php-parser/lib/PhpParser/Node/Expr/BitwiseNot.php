<?php

declare (strict_types=1);
namespace _PhpScoperf77bffce0320\PhpParser\Node\Expr;

use _PhpScoperf77bffce0320\PhpParser\Node\Expr;
class BitwiseNot extends \_PhpScoperf77bffce0320\PhpParser\Node\Expr
{
    /** @var Expr Expression */
    public $expr;
    /**
     * Constructs a bitwise not node.
     *
     * @param Expr  $expr       Expression
     * @param array $attributes Additional attributes
     */
    public function __construct(\_PhpScoperf77bffce0320\PhpParser\Node\Expr $expr, array $attributes = [])
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
        return 'Expr_BitwiseNot';
    }
}
