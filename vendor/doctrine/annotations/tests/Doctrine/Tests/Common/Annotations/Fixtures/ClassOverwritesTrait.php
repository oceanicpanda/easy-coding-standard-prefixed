<?php

namespace _PhpScoperf3db63c305b2\Doctrine\Tests\Common\Annotations\Fixtures;

use _PhpScoperf3db63c305b2\Doctrine\Tests\Common\Annotations\Bar2\Autoload;
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
namespace _PhpScoperf3db63c305b2\Doctrine\Tests\Common\Annotations\Bar2;

/** @Annotation */
class Autoload
{
}
