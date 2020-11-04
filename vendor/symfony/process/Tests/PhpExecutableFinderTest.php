<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper48b5ec5b60cf\Symfony\Component\Process\Tests;

use _PhpScoper48b5ec5b60cf\PHPUnit\Framework\TestCase;
use _PhpScoper48b5ec5b60cf\Symfony\Component\Process\PhpExecutableFinder;
/**
 * @author Robert Schönthal <seroscho@googlemail.com>
 */
class PhpExecutableFinderTest extends \_PhpScoper48b5ec5b60cf\PHPUnit\Framework\TestCase
{
    /**
     * tests find() with the constant PHP_BINARY.
     */
    public function testFind()
    {
        if (\defined('HHVM_VERSION')) {
            $this->markTestSkipped('Should not be executed in HHVM context.');
        }
        $f = new \_PhpScoper48b5ec5b60cf\Symfony\Component\Process\PhpExecutableFinder();
        $current = \PHP_BINARY;
        $args = 'phpdbg' === \PHP_SAPI ? ' -qrr' : '';
        $this->assertEquals($current . $args, $f->find(), '::find() returns the executable PHP');
        $this->assertEquals($current, $f->find(\false), '::find() returns the executable PHP');
    }
    /**
     * tests find() with the env var / constant PHP_BINARY with HHVM.
     */
    public function testFindWithHHVM()
    {
        if (!\defined('HHVM_VERSION')) {
            $this->markTestSkipped('Should be executed in HHVM context.');
        }
        $f = new \_PhpScoper48b5ec5b60cf\Symfony\Component\Process\PhpExecutableFinder();
        $current = \getenv('PHP_BINARY') ?: \PHP_BINARY;
        $this->assertEquals($current . ' --php', $f->find(), '::find() returns the executable PHP');
        $this->assertEquals($current, $f->find(\false), '::find() returns the executable PHP');
    }
    /**
     * tests find() with the env var PHP_PATH.
     */
    public function testFindArguments()
    {
        $f = new \_PhpScoper48b5ec5b60cf\Symfony\Component\Process\PhpExecutableFinder();
        if (\defined('HHVM_VERSION')) {
            $this->assertEquals($f->findArguments(), array('--php'), '::findArguments() returns HHVM arguments');
        } elseif ('phpdbg' === \PHP_SAPI) {
            $this->assertEquals($f->findArguments(), array('-qrr'), '::findArguments() returns phpdbg arguments');
        } else {
            $this->assertEquals($f->findArguments(), array(), '::findArguments() returns no arguments');
        }
    }
}
