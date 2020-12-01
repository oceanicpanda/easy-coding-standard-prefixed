<?php

declare (strict_types=1);
namespace _PhpScoperd74b3ed28382\PhpParser\Node\Expr\BinaryOp;

use _PhpScoperd74b3ed28382\PhpParser\Node\Expr\BinaryOp;
class Mod extends \_PhpScoperd74b3ed28382\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '%';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_Mod';
    }
}
