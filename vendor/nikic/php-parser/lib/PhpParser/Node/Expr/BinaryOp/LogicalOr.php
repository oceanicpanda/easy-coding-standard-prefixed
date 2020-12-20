<?php

declare (strict_types=1);
namespace _PhpScopera51a90153f58\PhpParser\Node\Expr\BinaryOp;

use _PhpScopera51a90153f58\PhpParser\Node\Expr\BinaryOp;
class LogicalOr extends \_PhpScopera51a90153f58\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return 'or';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_LogicalOr';
    }
}
