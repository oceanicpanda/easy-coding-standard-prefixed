<?php

declare (strict_types=1);
namespace _PhpScoper992f4af8b9e0\PhpParser\Node\Stmt;

use _PhpScoper992f4af8b9e0\PhpParser\Node;
/** Nop/empty statement (;). */
class Nop extends \_PhpScoper992f4af8b9e0\PhpParser\Node\Stmt
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
