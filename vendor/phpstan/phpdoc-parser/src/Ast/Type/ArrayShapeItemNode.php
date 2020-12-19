<?php

declare (strict_types=1);
namespace _PhpScopera6f918786d5c\PHPStan\PhpDocParser\Ast\Type;

use _PhpScopera6f918786d5c\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode;
use _PhpScopera6f918786d5c\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode;
class ArrayShapeItemNode implements \_PhpScopera6f918786d5c\PHPStan\PhpDocParser\Ast\Type\TypeNode
{
    /** @var ConstExprIntegerNode|ConstExprStringNode|IdentifierTypeNode|null */
    public $keyName;
    /** @var bool */
    public $optional;
    /** @var TypeNode */
    public $valueType;
    /**
     * @param ConstExprIntegerNode|ConstExprStringNode|IdentifierTypeNode|null $keyName
     */
    public function __construct($keyName, bool $optional, \_PhpScopera6f918786d5c\PHPStan\PhpDocParser\Ast\Type\TypeNode $valueType)
    {
        $this->keyName = $keyName;
        $this->optional = $optional;
        $this->valueType = $valueType;
    }
    public function __toString() : string
    {
        if ($this->keyName !== null) {
            return \sprintf('%s%s: %s', (string) $this->keyName, $this->optional ? '?' : '', (string) $this->valueType);
        }
        return (string) $this->valueType;
    }
}
