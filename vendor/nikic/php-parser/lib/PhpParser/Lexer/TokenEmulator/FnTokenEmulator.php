<?php

declare (strict_types=1);
namespace _PhpScoper59da9ac954a6\PhpParser\Lexer\TokenEmulator;

use _PhpScoper59da9ac954a6\PhpParser\Lexer\Emulative;
final class FnTokenEmulator extends \_PhpScoper59da9ac954a6\PhpParser\Lexer\TokenEmulator\KeywordEmulator
{
    public function getPhpVersion() : string
    {
        return \_PhpScoper59da9ac954a6\PhpParser\Lexer\Emulative::PHP_7_4;
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
