<?php

namespace _PhpScoperf3db63c305b2\Doctrine\Tests\Common\Annotations\Fixtures;

use _PhpScoperf3db63c305b2\Doctrine\Tests\Common\Annotations\Fixtures\Annotation\Secure;
interface TestInterface
{
    /**
     * @Secure
     */
    function foo();
}
