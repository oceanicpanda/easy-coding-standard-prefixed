<?php

declare (strict_types=1);
namespace _PhpScoperbd5fb781fe24\PhpParser\Node\Expr\BinaryOp;

use _PhpScoperbd5fb781fe24\PhpParser\Node\Expr\BinaryOp;
class NotIdentical extends \_PhpScoperbd5fb781fe24\PhpParser\Node\Expr\BinaryOp
{
    public function getOperatorSigil() : string
    {
        return '!==';
    }
    public function getType() : string
    {
        return 'Expr_BinaryOp_NotIdentical';
    }
}
