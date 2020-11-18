<?php

declare (strict_types=1);
namespace _PhpScoperf77bffce0320\PhpParser\Node\Expr\BinaryOp;

use _PhpScoperf77bffce0320\PhpParser\Node\Expr\BinaryOp;
class BitwiseXor extends \_PhpScoperf77bffce0320\PhpParser\Node\Expr\BinaryOp
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
