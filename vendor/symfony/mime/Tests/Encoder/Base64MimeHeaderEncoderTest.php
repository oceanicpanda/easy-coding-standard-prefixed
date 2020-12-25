<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper7c1f54fd2f3a\Symfony\Component\Mime\Tests\Encoder;

use _PhpScoper7c1f54fd2f3a\PHPUnit\Framework\TestCase;
use _PhpScoper7c1f54fd2f3a\Symfony\Component\Mime\Encoder\Base64MimeHeaderEncoder;
class Base64MimeHeaderEncoderTest extends \_PhpScoper7c1f54fd2f3a\PHPUnit\Framework\TestCase
{
    public function testNameIsB()
    {
        $this->assertEquals('B', (new \_PhpScoper7c1f54fd2f3a\Symfony\Component\Mime\Encoder\Base64MimeHeaderEncoder())->getName());
    }
}
