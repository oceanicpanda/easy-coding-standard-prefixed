<?php

namespace _PhpScoper4972b76c81a2\Doctrine\Tests\Common\Annotations\Fixtures;

use _PhpScoper4972b76c81a2\Doctrine\Tests\Common\Annotations\Bar2\Autoload;
class ClassOverwritesTrait
{
    use TraitWithAnnotatedMethod;
    /**
     * @Autoload
     */
    public function traitMethod()
    {
    }
}
namespace _PhpScoper4972b76c81a2\Doctrine\Tests\Common\Annotations\Bar2;

/** @Annotation */
class Autoload
{
}
