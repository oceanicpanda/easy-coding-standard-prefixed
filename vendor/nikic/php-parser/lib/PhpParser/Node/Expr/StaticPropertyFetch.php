<?php

declare (strict_types=1);
namespace _PhpScoperd74b3ed28382\PhpParser\Node\Expr;

use _PhpScoperd74b3ed28382\PhpParser\Node\Expr;
use _PhpScoperd74b3ed28382\PhpParser\Node\Name;
use _PhpScoperd74b3ed28382\PhpParser\Node\VarLikeIdentifier;
class StaticPropertyFetch extends \_PhpScoperd74b3ed28382\PhpParser\Node\Expr
{
    /** @var Name|Expr Class name */
    public $class;
    /** @var VarLikeIdentifier|Expr Property name */
    public $name;
    /**
     * Constructs a static property fetch node.
     *
     * @param Name|Expr                     $class      Class name
     * @param string|VarLikeIdentifier|Expr $name       Property name
     * @param array                         $attributes Additional attributes
     */
    public function __construct($class, $name, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->class = $class;
        $this->name = \is_string($name) ? new \_PhpScoperd74b3ed28382\PhpParser\Node\VarLikeIdentifier($name) : $name;
    }
    public function getSubNodeNames() : array
    {
        return ['class', 'name'];
    }
    public function getType() : string
    {
        return 'Expr_StaticPropertyFetch';
    }
}
