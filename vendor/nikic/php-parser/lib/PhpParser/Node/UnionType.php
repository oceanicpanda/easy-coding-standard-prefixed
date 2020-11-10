<?php

declare (strict_types=1);
namespace _PhpScopere5e7dca8c031\PhpParser\Node;

use _PhpScopere5e7dca8c031\PhpParser\NodeAbstract;
class UnionType extends \_PhpScopere5e7dca8c031\PhpParser\NodeAbstract
{
    /** @var (Identifier|Name)[] Types */
    public $types;
    /**
     * Constructs a union type.
     *
     * @param (Identifier|Name)[] $types      Types
     * @param array               $attributes Additional attributes
     */
    public function __construct(array $types, array $attributes = [])
    {
        $this->attributes = $attributes;
        $this->types = $types;
    }
    public function getSubNodeNames() : array
    {
        return ['types'];
    }
    public function getType() : string
    {
        return 'UnionType';
    }
}
