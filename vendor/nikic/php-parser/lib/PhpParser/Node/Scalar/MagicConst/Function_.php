<?php

declare (strict_types=1);
namespace _PhpScoper269dc521b0fa\PhpParser\Node\Scalar\MagicConst;

use _PhpScoper269dc521b0fa\PhpParser\Node\Scalar\MagicConst;
class Function_ extends \_PhpScoper269dc521b0fa\PhpParser\Node\Scalar\MagicConst
{
    public function getName() : string
    {
        return '__FUNCTION__';
    }
    public function getType() : string
    {
        return 'Scalar_MagicConst_Function';
    }
}
