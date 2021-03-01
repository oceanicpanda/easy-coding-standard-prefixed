<?php

declare (strict_types=1);
namespace _PhpScoper06c5fb6c14ed\PhpParser\Node\Expr;

use _PhpScoper06c5fb6c14ed\PhpParser\Node\Expr;
class BitwiseNot extends \_PhpScoper06c5fb6c14ed\PhpParser\Node\Expr
{
    /** @var Expr Expression */
    public $expr;
    /**
     * Constructs a bitwise not node.
     *
     * @param Expr  $expr       Expression
     * @param array $attributes Additional attributes
     */
    public function __construct(\_PhpScoper06c5fb6c14ed\PhpParser\Node\Expr $expr, array $attributes = [])
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
