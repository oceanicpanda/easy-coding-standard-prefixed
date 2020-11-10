<?php

declare (strict_types=1);
namespace _PhpScopere5e7dca8c031\PhpParser\Node\Expr\BinaryOp;

use _PhpScopere5e7dca8c031\PhpParser\Node\Expr\BinaryOp;
class LogicalXor extends \_PhpScopere5e7dca8c031\PhpParser\Node\Expr\BinaryOp
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
