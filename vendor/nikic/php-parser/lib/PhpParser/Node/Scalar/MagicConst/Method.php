<?php

declare (strict_types=1);
namespace _PhpScopera09818bc50da\PhpParser\Node\Scalar\MagicConst;

use _PhpScopera09818bc50da\PhpParser\Node\Scalar\MagicConst;
class Method extends \_PhpScopera09818bc50da\PhpParser\Node\Scalar\MagicConst
{
    public function getName() : string
    {
        return '__METHOD__';
    }
    public function getType() : string
    {
        return 'Scalar_MagicConst_Method';
    }
}
