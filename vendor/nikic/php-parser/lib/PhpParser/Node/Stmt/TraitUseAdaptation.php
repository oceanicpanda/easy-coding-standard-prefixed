<?php

declare (strict_types=1);
namespace _PhpScopera51a90153f58\PhpParser\Node\Stmt;

use _PhpScopera51a90153f58\PhpParser\Node;
abstract class TraitUseAdaptation extends \_PhpScopera51a90153f58\PhpParser\Node\Stmt
{
    /** @var Node\Name|null Trait name */
    public $trait;
    /** @var Node\Identifier Method name */
    public $method;
}
