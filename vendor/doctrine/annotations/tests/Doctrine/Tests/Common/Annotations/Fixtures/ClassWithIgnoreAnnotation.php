<?php

namespace _PhpScopercda2b863d098\Doctrine\Tests\Common\Annotations\Fixtures;

/**
 * @ignoreAnnotation("IgnoreAnnotationClass")
 */
class ClassWithIgnoreAnnotation
{
    /**
     * @IgnoreAnnotationClass
     */
    public $foo;
}
