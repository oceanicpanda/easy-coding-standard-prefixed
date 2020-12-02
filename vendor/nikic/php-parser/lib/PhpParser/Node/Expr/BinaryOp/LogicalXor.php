<?php

declare (strict_types=1);
namespace _PhpScopera23ebff5477f\PhpParser\Node\Expr\BinaryOp;

use _PhpScopera23ebff5477f\PhpParser\Node\Expr\BinaryOp;
class LogicalXor extends \_PhpScopera23ebff5477f\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return 'xor';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_LogicalXor';
    }
}
