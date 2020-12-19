<?php

declare (strict_types=1);
namespace _PhpScopera6f918786d5c\PhpParser\Node\Expr;

use _PhpScopera6f918786d5c\PhpParser\Node\Expr;
use _PhpScopera6f918786d5c\PhpParser\Node\Identifier;
use _PhpScopera6f918786d5c\PhpParser\Node\Name;
class ClassConstFetch extends \_PhpScopera6f918786d5c\PhpParser\Node\Expr
{
    /** @var Name|Expr Class name */
    public $class;
    /** @var Identifier|Error Constant name */
    public $name;
    /**
     * Constructs a class const fetch node.
     *
     * @param Name|Expr               $class      Class name
     * @param string|Identifier|Error $name       Constant name
     * @param array                   $attributes Additional attributes
     */
    public function __construct($class, $name, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->class = $class;
        $this->name = \is_string($name) ? new \_PhpScopera6f918786d5c\PhpParser\Node\Identifier($name) : $name;
    }
    public function getSubNodeNames() : array
    {
        return ['class', 'name'];
    }
    public function getType() : string
    {
        return 'Expr_ClassConstFetch';
    }
}
