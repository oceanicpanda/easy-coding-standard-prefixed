<?php

declare (strict_types=1);
namespace _PhpScopera51a90153f58\PhpParser\Node\Scalar\MagicConst;

use _PhpScopera51a90153f58\PhpParser\Node\Scalar\MagicConst;
class File extends \_PhpScopera51a90153f58\PhpParser\Node\Scalar\MagicConst
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
