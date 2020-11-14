<?php

declare (strict_types=1);
namespace _PhpScoperb09c3ec8e01a\PHPStan\PhpDocParser\Ast\PhpDoc;

use _PhpScoperb09c3ec8e01a\PHPStan\PhpDocParser\Ast\Type\TypeNode;
class ThrowsTagValueNode implements \_PhpScoperb09c3ec8e01a\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
{
    /** @var TypeNode */
    public $type;
    /** @var string (may be empty) */
    public $description;
    public function __construct(\_PhpScoperb09c3ec8e01a\PHPStan\PhpDocParser\Ast\Type\TypeNode $type, string $description)
    {
        $this->type = $type;
        $this->description = $description;
    }
    public function __toString() : string
    {
        return \trim("{$this->type} {$this->description}");
    }
}
