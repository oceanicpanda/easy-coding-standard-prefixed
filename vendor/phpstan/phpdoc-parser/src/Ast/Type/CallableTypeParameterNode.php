<?php

declare (strict_types=1);
namespace _PhpScoper7145e5e87de5\PHPStan\PhpDocParser\Ast\Type;

use _PhpScoper7145e5e87de5\PHPStan\PhpDocParser\Ast\Node;
class CallableTypeParameterNode implements \_PhpScoper7145e5e87de5\PHPStan\PhpDocParser\Ast\Node
{
    /** @var TypeNode */
    public $type;
    /** @var bool */
    public $isReference;
    /** @var bool */
    public $isVariadic;
    /** @var string (may be empty) */
    public $parameterName;
    /** @var bool */
    public $isOptional;
    public function __construct(\_PhpScoper7145e5e87de5\PHPStan\PhpDocParser\Ast\Type\TypeNode $type, bool $isReference, bool $isVariadic, string $parameterName, bool $isOptional)
    {
        $this->type = $type;
        $this->isReference = $isReference;
        $this->isVariadic = $isVariadic;
        $this->parameterName = $parameterName;
        $this->isOptional = $isOptional;
    }
    public function __toString() : string
    {
        $type = "{$this->type} ";
        $isReference = $this->isReference ? '&' : '';
        $isVariadic = $this->isVariadic ? '...' : '';
        $default = $this->isOptional ? ' = default' : '';
        return "{$type}{$isReference}{$isVariadic}{$this->parameterName}{$default}";
    }
}
