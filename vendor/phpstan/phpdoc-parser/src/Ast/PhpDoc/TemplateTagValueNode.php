<?php

declare (strict_types=1);
namespace _PhpScopera88a8b9f064a\PHPStan\PhpDocParser\Ast\PhpDoc;

use _PhpScopera88a8b9f064a\PHPStan\PhpDocParser\Ast\Type\TypeNode;
class TemplateTagValueNode implements \_PhpScopera88a8b9f064a\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
{
    /** @var string */
    public $name;
    /** @var TypeNode|null */
    public $bound;
    /** @var string (may be empty) */
    public $description;
    public function __construct(string $name, ?\_PhpScopera88a8b9f064a\PHPStan\PhpDocParser\Ast\Type\TypeNode $bound, string $description)
    {
        $this->name = $name;
        $this->bound = $bound;
        $this->description = $description;
    }
    public function __toString() : string
    {
        $bound = $this->bound !== null ? " of {$this->bound}" : '';
        return \trim("{$this->name}{$bound} {$this->description}");
    }
}
