<?php

declare (strict_types=1);
namespace _PhpScoper13160cf3462c\PhpParser\Node\Expr;

use _PhpScoper13160cf3462c\PhpParser\Node;
use _PhpScoper13160cf3462c\PhpParser\Node\Expr;
class New_ extends \_PhpScoper13160cf3462c\PhpParser\Node\Expr
{
    /** @var Node\Name|Expr|Node\Stmt\Class_ Class name */
    public $class;
    /** @var Node\Arg[] Arguments */
    public $args;
    /**
     * Constructs a function call node.
     *
     * @param Node\Name|Expr|Node\Stmt\Class_ $class      Class name (or class node for anonymous classes)
     * @param Node\Arg[]                      $args       Arguments
     * @param array                           $attributes Additional attributes
     */
    public function __construct($class, array $args = [], array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->class = $class;
        $this->args = $args;
    }
    public function getSubNodeNames() : array
    {
        return ['class', 'args'];
    }
    public function getType() : string
    {
        return 'Expr_New';
    }
}
