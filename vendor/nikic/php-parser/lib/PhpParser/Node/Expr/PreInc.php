<?php

declare (strict_types=1);
namespace _PhpScoperb458b528613f\PhpParser\Node\Expr;

use _PhpScoperb458b528613f\PhpParser\Node\Expr;
class PreInc extends \_PhpScoperb458b528613f\PhpParser\Node\Expr
{
    /** @var Expr Variable */
    public $var;
    /**
     * Constructs a pre increment node.
     *
     * @param Expr  $var        Variable
     * @param array $attributes Additional attributes
     */
    public function __construct(\_PhpScoperb458b528613f\PhpParser\Node\Expr $var, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->var = $var;
    }
    public function getSubNodeNames() : array
    {
        return ['var'];
    }
    public function getType() : string
    {
        return 'Expr_PreInc';
    }
}
