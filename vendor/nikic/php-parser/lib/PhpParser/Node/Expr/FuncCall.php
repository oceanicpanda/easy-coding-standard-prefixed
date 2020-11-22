<?php

declare (strict_types=1);
namespace _PhpScopera88a8b9f064a\PhpParser\Node\Expr;

use _PhpScopera88a8b9f064a\PhpParser\Node;
use _PhpScopera88a8b9f064a\PhpParser\Node\Expr;
class FuncCall extends \_PhpScopera88a8b9f064a\PhpParser\Node\Expr
{
    /** @var Node\Name|Expr Function name */
    public $name;
    /** @var Node\Arg[] Arguments */
    public $args;
    /**
     * Constructs a function call node.
     *
     * @param Node\Name|Expr $name       Function name
     * @param Node\Arg[]     $args       Arguments
     * @param array          $attributes Additional attributes
     */
    public function __construct($name, array $args = [], array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->name = $name;
        $this->args = $args;
    }
    public function getSubNodeNames() : array
    {
        return ['name', 'args'];
    }
    public function getType() : string
    {
        return 'Expr_FuncCall';
    }
}
