<?php

declare (strict_types=1);
namespace _PhpScopera6f918786d5c\PhpParser\Node\Expr;

use _PhpScopera6f918786d5c\PhpParser\Node\Expr;
abstract class BinaryOp extends \_PhpScopera6f918786d5c\PhpParser\Node\Expr
{
    /** @var Expr The left hand side expression */
    public $left;
    /** @var Expr The right hand side expression */
    public $right;
    /**
     * Constructs a binary operator node.
     *
     * @param Expr  $left       The left hand side expression
     * @param Expr  $right      The right hand side expression
     * @param array $attributes Additional attributes
     */
    public function __construct(\_PhpScopera6f918786d5c\PhpParser\Node\Expr $left, \_PhpScopera6f918786d5c\PhpParser\Node\Expr $right, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->left = $left;
        $this->right = $right;
    }
    public function getSubNodeNames() : array
    {
        return ['left', 'right'];
    }
    /**
     * Get the operator sigil for this binary operation.
     *
     * In the case there are multiple possible sigils for an operator, this method does not
     * necessarily return the one used in the parsed code.
     *
     * @return string
     */
    public abstract function getOperatorSigil() : string;
}
