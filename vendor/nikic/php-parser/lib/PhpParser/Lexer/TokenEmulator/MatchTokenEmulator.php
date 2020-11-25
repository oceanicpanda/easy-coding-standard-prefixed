<?php

declare (strict_types=1);
namespace _PhpScoper418afc2f157c\PhpParser\Lexer\TokenEmulator;

use _PhpScoper418afc2f157c\PhpParser\Lexer\Emulative;
final class MatchTokenEmulator extends \_PhpScoper418afc2f157c\PhpParser\Lexer\TokenEmulator\KeywordEmulator
{
    public function getPhpVersion() : string
    {
        return \_PhpScoper418afc2f157c\PhpParser\Lexer\Emulative::PHP_8_0;
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
