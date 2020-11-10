<?php

declare (strict_types=1);
namespace _PhpScoper0c236037eb04\PhpParser\Lexer\TokenEmulator;

/** @internal */
interface TokenEmulatorInterface
{
    public function getPhpVersion() : string;
    public function isEmulationNeeded(string $code) : bool;
    /**
     * @return array Modified Tokens
     */
    public function emulate(string $code, array $tokens) : array;
    /**
     * @return array Modified Tokens
     */
    public function reverseEmulate(string $code, array $tokens) : array;
}