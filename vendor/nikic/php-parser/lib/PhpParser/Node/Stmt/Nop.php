<?php

declare (strict_types=1);
namespace _PhpScoper89ec3c69e67d\PhpParser\Node\Stmt;

use _PhpScoper89ec3c69e67d\PhpParser\Node;
/** Nop/empty statement (;). */
class Nop extends \_PhpScoper89ec3c69e67d\PhpParser\Node\Stmt
{
    public function getSubNodeNames() : array
    {
        return [];
    }
    public function getType() : string
    {
        return 'Stmt_Nop';
    }
}
