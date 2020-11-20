<?php

declare (strict_types=1);
namespace _PhpScoperc753ccca5a0c\PhpParser\Node;

use _PhpScoperc753ccca5a0c\PhpParser\NodeAbstract;
/**
 * @property Name $namespacedName Namespaced name (for class constants, if using NameResolver)
 */
class Const_ extends \_PhpScoperc753ccca5a0c\PhpParser\NodeAbstract
{
    /** @var Identifier Name */
    public $name;
    /** @var Expr Value */
    public $value;
    /**
     * Constructs a const node for use in class const and const statements.
     *
     * @param string|Identifier $name       Name
     * @param Expr              $value      Value
     * @param array             $attributes Additional attributes
     */
    public function __construct($name, \_PhpScoperc753ccca5a0c\PhpParser\Node\Expr $value, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->name = \is_string($name) ? new \_PhpScoperc753ccca5a0c\PhpParser\Node\Identifier($name) : $name;
        $this->value = $value;
    }
    public function getSubNodeNames() : array
    {
        return ['name', 'value'];
    }
    public function getType() : string
    {
        return 'Const';
    }
}
