<?php

namespace _PhpScoper21c6ce8bfe5d\Doctrine\Tests\Common\Annotations\Fixtures;

use _PhpScoper21c6ce8bfe5d\Doctrine\Tests\Common\Annotations\Bar\Autoload;
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
namespace _PhpScoper21c6ce8bfe5d\Doctrine\Tests\Common\Annotations\Bar;

/** @Annotation */
class Autoload
{
}
