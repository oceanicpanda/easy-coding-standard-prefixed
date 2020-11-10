<?php

declare (strict_types=1);
namespace _PhpScopere5e7dca8c031\PHPStan\PhpDocParser\Ast\PhpDoc;

class DeprecatedTagValueNode implements \_PhpScopere5e7dca8c031\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
{
    /** @var string (may be empty) */
    public $description;
    public function __construct(string $description)
    {
        $this->description = $description;
    }
    public function __toString() : string
    {
        return \trim($this->description);
    }
}
