<?php

declare (strict_types=1);
namespace _PhpScopera88a8b9f064a\PhpParser\Node\Expr\BinaryOp;

use _PhpScopera88a8b9f064a\PhpParser\Node\Expr\BinaryOp;
class BitwiseXor extends \_PhpScopera88a8b9f064a\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '^';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_BitwiseXor';
    }
}
