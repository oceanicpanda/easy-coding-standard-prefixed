<?php

namespace _PhpScoper992f4af8b9e0\Doctrine\Tests\Common\Annotations\Fixtures;

use _PhpScoper992f4af8b9e0\Doctrine\Tests\Common\Annotations\Bar\Autoload;
class ClassUsesTrait
{
    use TraitWithAnnotatedMethod;
    /**
     * @Autoload
     */
    public $aProperty;
    /**
     * @Autoload
     */
    public function someMethod()
    {
    }
}
namespace _PhpScoper992f4af8b9e0\Doctrine\Tests\Common\Annotations\Bar;

/** @Annotation */
class Autoload
{
}
