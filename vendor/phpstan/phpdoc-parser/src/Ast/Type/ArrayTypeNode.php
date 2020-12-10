<?php

declare (strict_types=1);
namespace _PhpScoperb458b528613f\PHPStan\PhpDocParser\Ast\Type;

class ArrayTypeNode implements \_PhpScoperb458b528613f\PHPStan\PhpDocParser\Ast\Type\TypeNode
{
    /** @var TypeNode */
    public $type;
    public function __construct(\_PhpScoperb458b528613f\PHPStan\PhpDocParser\Ast\Type\TypeNode $type)
    {
        $this->type = $type;
    }
    public function __toString() : string
    {
        return $this->type . '[]';
    }
}
