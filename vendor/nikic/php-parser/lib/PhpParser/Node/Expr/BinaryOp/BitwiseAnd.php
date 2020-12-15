<?php

declare (strict_types=1);
namespace _PhpScoper839420027581\PhpParser\Node\Expr\BinaryOp;

use _PhpScoper839420027581\PhpParser\Node\Expr\BinaryOp;
class BitwiseAnd extends \_PhpScoper839420027581\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '&';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_BitwiseAnd';
    }
}
