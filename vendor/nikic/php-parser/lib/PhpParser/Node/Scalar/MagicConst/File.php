<?php

declare (strict_types=1);
namespace _PhpScoper64a921a5401b\PhpParser\Node\Scalar\MagicConst;

use _PhpScoper64a921a5401b\PhpParser\Node\Scalar\MagicConst;
class File extends \_PhpScoper64a921a5401b\PhpParser\Node\Scalar\MagicConst
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
