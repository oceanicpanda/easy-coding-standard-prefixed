<?php

declare (strict_types=1);
namespace _PhpScoper3639953bb9e5\PhpParser\Node\Stmt;

use _PhpScoper3639953bb9e5\PhpParser\Node;
/** Nop/empty statement (;). */
class Nop extends \_PhpScoper3639953bb9e5\PhpParser\Node\Stmt
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
