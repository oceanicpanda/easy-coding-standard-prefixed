<?php

declare (strict_types=1);
namespace _PhpScopera23ebff5477f\PhpParser\Node\Stmt;

use _PhpScopera23ebff5477f\PhpParser\Node;
class Break_ extends \_PhpScopera23ebff5477f\PhpParser\Node\Stmt
{
    /** @var null|Node\Expr Number of loops to break */
    public $num;
    /**
     * Constructs a break node.
     *
     * @param null|Node\Expr $num        Number of loops to break
     * @param array          $attributes Additional attributes
     */
    public function __construct(\_PhpScopera23ebff5477f\PhpParser\Node\Expr $num = null, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->num = $num;
    }
    public function getSubNodeNames() : array
    {
        return ['num'];
    }
    public function getType() : string
    {
        return 'Stmt_Break';
    }
}
