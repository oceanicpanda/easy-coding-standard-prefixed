<?php

declare (strict_types=1);
namespace _PhpScoper3d04c8135695\PhpParser\Node\Expr\BinaryOp;

use _PhpScoper3d04c8135695\PhpParser\Node\Expr\BinaryOp;
class Smaller extends \_PhpScoper3d04c8135695\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '<';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_Smaller';
    }
}
