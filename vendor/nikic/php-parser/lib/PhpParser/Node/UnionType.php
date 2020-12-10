<?php

declare (strict_types=1);
namespace _PhpScoper17bb67c99ade\PhpParser\Node;

use _PhpScoper17bb67c99ade\PhpParser\NodeAbstract;
class UnionType extends \_PhpScoper17bb67c99ade\PhpParser\NodeAbstract
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
