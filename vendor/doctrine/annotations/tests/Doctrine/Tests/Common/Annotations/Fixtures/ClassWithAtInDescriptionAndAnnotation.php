<?php

namespace _PhpScopera88a8b9f064a\Doctrine\Tests\Common\Annotations\Fixtures;

use _PhpScopera88a8b9f064a\Doctrine\Tests\Common\Annotations\Fixtures\AnnotationTargetPropertyMethod;
class ClassWithAtInDescriptionAndAnnotation
{
    /**
     * Lala
     *
     * {
     *     "email": "foo@example.com",
     *     "email2": "123@example.com",
     *     "email3": "@example.com"
     * }
     *
     * @AnnotationTargetPropertyMethod("Bar")
     */
    public $foo;
    /**
     * Lala
     *
     * {
     *     "email": "foo@example.com",
     *     "email2": "123@example.com",
     *     "email3": "@example.com"
     * }
     *
     *@AnnotationTargetPropertyMethod("Bar")
     */
    public $bar;
}
