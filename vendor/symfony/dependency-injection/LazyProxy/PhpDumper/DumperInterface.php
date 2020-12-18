<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperd8b12759ee0d\Symfony\Component\DependencyInjection\LazyProxy\PhpDumper;

use _PhpScoperd8b12759ee0d\Symfony\Component\DependencyInjection\Definition;
/**
 * Lazy proxy dumper capable of generating the instantiation logic PHP code for proxied services.
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 */
interface DumperInterface
{
    /**
     * Inspects whether the given definitions should produce proxy instantiation logic in the dumped container.
     *
     * @return bool
     */
    public function isProxyCandidate(\_PhpScoperd8b12759ee0d\Symfony\Component\DependencyInjection\Definition $definition);
    /**
     * Generates the code to be used to instantiate a proxy in the dumped factory code.
     *
     * @return string
     */
    public function getProxyFactoryCode(\_PhpScoperd8b12759ee0d\Symfony\Component\DependencyInjection\Definition $definition, string $id, string $factoryCode);
    /**
     * Generates the code for the lazy proxy.
     *
     * @return string
     */
    public function getProxyCode(\_PhpScoperd8b12759ee0d\Symfony\Component\DependencyInjection\Definition $definition);
}
