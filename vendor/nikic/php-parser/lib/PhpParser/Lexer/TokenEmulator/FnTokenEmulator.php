<?php

declare (strict_types=1);
namespace _PhpScoper89ec3c69e67d\PhpParser\Lexer\TokenEmulator;

use _PhpScoper89ec3c69e67d\PhpParser\Lexer\Emulative;
final class FnTokenEmulator extends \_PhpScoper89ec3c69e67d\PhpParser\Lexer\TokenEmulator\KeywordEmulator
{
    public function getPhpVersion() : string
    {
        return \_PhpScoper89ec3c69e67d\PhpParser\Lexer\Emulative::PHP_7_4;
    }
    public function getKeywordString() : string
    {
        return 'fn';
    }
    public function getKeywordToken() : int
    {
        return \T_FN;
    }
}
