<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper4972b76c81a2\Symfony\Component\VarDumper\Dumper\ContextProvider;

/**
 * Tries to provide context on CLI.
 *
 * @author Maxime Steinhausser <maxime.steinhausser@gmail.com>
 */
final class CliContextProvider implements \_PhpScoper4972b76c81a2\Symfony\Component\VarDumper\Dumper\ContextProvider\ContextProviderInterface
{
    public function getContext() : ?array
    {
        if ('cli' !== \PHP_SAPI) {
            return null;
        }
        return ['command_line' => $commandLine = \implode(' ', $_SERVER['argv']), 'identifier' => \hash('crc32b', $commandLine . $_SERVER['REQUEST_TIME_FLOAT'])];
    }
}
