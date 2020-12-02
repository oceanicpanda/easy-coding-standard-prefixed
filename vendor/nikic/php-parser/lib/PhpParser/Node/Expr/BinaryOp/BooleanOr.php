<?php

declare (strict_types=1);
namespace _PhpScopera34ae19e8d40\PhpParser\Node\Expr\BinaryOp;

use _PhpScopera34ae19e8d40\PhpParser\Node\Expr\BinaryOp;
class BooleanOr extends \_PhpScopera34ae19e8d40\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '||';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_BooleanOr';
    }
}
