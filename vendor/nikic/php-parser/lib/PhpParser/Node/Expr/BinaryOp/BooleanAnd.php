<?php

declare (strict_types=1);
namespace _PhpScoper3639953bb9e5\PhpParser\Node\Expr\BinaryOp;

use _PhpScoper3639953bb9e5\PhpParser\Node\Expr\BinaryOp;
class BooleanAnd extends \_PhpScoper3639953bb9e5\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '&&';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_BooleanAnd';
    }
}
