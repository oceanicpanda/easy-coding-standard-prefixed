<?php

declare (strict_types=1);
namespace _PhpScoperb09c3ec8e01a\PhpParser\Node\Scalar\MagicConst;

use _PhpScoperb09c3ec8e01a\PhpParser\Node\Scalar\MagicConst;
class File extends \_PhpScoperb09c3ec8e01a\PhpParser\Node\Scalar\MagicConst
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
