<?php

declare (strict_types=1);
namespace _PhpScoper59da9ac954a6\PhpParser\Node;

use _PhpScoper59da9ac954a6\PhpParser\Node;
use _PhpScoper59da9ac954a6\PhpParser\NodeAbstract;
class Attribute extends \_PhpScoper59da9ac954a6\PhpParser\NodeAbstract
{
    /** @var Name Attribute name */
    public $name;
    /** @var Arg[] Attribute arguments */
    public $args;
    /**
     * @param Node\Name $name       Attribute name
     * @param Arg[]     $args       Attribute arguments
     * @param array     $attributes Additional node attributes
     */
    public function __construct(\_PhpScoper59da9ac954a6\PhpParser\Node\Name $name, array $args = [], array $attributes = [])
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
        return 'Attribute';
    }
}
