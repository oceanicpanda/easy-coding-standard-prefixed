<?php

declare (strict_types=1);
namespace _PhpScopera6f918786d5c\PhpParser\Node\Scalar\MagicConst;

use _PhpScopera6f918786d5c\PhpParser\Node\Scalar\MagicConst;
class File extends \_PhpScopera6f918786d5c\PhpParser\Node\Scalar\MagicConst
{
    public function getName() : string
    {
        return '__FILE__';
    }
    public function getType() : string
    {
        return 'Scalar_MagicConst_File';
    }
}
