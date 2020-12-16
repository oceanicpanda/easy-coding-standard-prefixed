<?php

declare (strict_types=1);
namespace _PhpScoperb6a8e65b492c\PhpParser\Lexer\TokenEmulator;

use _PhpScoperb6a8e65b492c\PhpParser\Lexer\Emulative;
final class MatchTokenEmulator extends \_PhpScoperb6a8e65b492c\PhpParser\Lexer\TokenEmulator\KeywordEmulator
{
    public function getPhpVersion() : string
    {
        return \_PhpScoperb6a8e65b492c\PhpParser\Lexer\Emulative::PHP_8_0;
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
