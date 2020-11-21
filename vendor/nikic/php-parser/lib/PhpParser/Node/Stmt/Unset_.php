<?php

declare (strict_types=1);
namespace _PhpScopera4be459e5e3d\PhpParser\Node\Stmt;

use _PhpScopera4be459e5e3d\PhpParser\Node;
class Unset_ extends \_PhpScopera4be459e5e3d\PhpParser\Node\Stmt
{
    /** @var Node\Expr[] Variables to unset */
    public $vars;
    /**
     * Constructs an unset node.
     *
     * @param Node\Expr[] $vars       Variables to unset
     * @param array       $attributes Additional attributes
     */
    public function __construct(array $vars, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->vars = $vars;
    }
    public function getSubNodeNames() : array
    {
        return ['vars'];
    }
    public function getType() : string
    {
        return 'Stmt_Unset';
    }
}
