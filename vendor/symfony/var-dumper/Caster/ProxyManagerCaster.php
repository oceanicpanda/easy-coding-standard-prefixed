<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper7c1f54fd2f3a\Symfony\Component\VarDumper\Caster;

use _PhpScoper7c1f54fd2f3a\ProxyManager\Proxy\ProxyInterface;
use _PhpScoper7c1f54fd2f3a\Symfony\Component\VarDumper\Cloner\Stub;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 *
 * @final since Symfony 4.4
 */
class ProxyManagerCaster
{
    public static function castProxy(\_PhpScoper7c1f54fd2f3a\ProxyManager\Proxy\ProxyInterface $c, array $a, \_PhpScoper7c1f54fd2f3a\Symfony\Component\VarDumper\Cloner\Stub $stub, $isNested)
    {
        if ($parent = \get_parent_class($c)) {
            $stub->class .= ' - ' . $parent;
        }
        $stub->class .= '@proxy';
        return $a;
    }
}
