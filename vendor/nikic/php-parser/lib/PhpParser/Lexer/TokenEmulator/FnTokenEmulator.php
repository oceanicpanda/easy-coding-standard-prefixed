<?php

declare (strict_types=1);
namespace _PhpScoperd74b3ed28382\PhpParser\Lexer\TokenEmulator;

use _PhpScoperd74b3ed28382\PhpParser\Lexer\Emulative;
final class FnTokenEmulator extends \_PhpScoperd74b3ed28382\PhpParser\Lexer\TokenEmulator\KeywordEmulator
{
    public function getPhpVersion() : string
    {
        return \_PhpScoperd74b3ed28382\PhpParser\Lexer\Emulative::PHP_7_4;
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
