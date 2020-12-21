<?php

declare (strict_types=1);
namespace _PhpScoperfcf15c26e033\PhpParser\Lexer\TokenEmulator;

use _PhpScoperfcf15c26e033\PhpParser\Lexer\Emulative;
final class MatchTokenEmulator extends \_PhpScoperfcf15c26e033\PhpParser\Lexer\TokenEmulator\KeywordEmulator
{
    public function getPhpVersion() : string
    {
        return \_PhpScoperfcf15c26e033\PhpParser\Lexer\Emulative::PHP_8_0;
    }
    public function getKeywordString() : string
    {
        return 'match';
    }
    public function getKeywordToken() : int
    {
        return \T_MATCH;
    }
}
