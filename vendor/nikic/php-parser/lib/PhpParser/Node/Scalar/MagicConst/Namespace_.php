<?php

declare (strict_types=1);
namespace _PhpScoper80dbed43490f\PhpParser\Node\Scalar\MagicConst;

use _PhpScoper80dbed43490f\PhpParser\Node\Scalar\MagicConst;
class Namespace_ extends \_PhpScoper80dbed43490f\PhpParser\Node\Scalar\MagicConst
{
    public function getName() : string
    {
        return '__NAMESPACE__';
    }
    public function getType() : string
    {
        return 'Scalar_MagicConst_Namespace';
    }
}
