<?php

declare (strict_types=1);
namespace Symplify\CodingStandard\TokenRunner\DocBlock\MalformWorker;

use _PhpScoper0d0ee1ba46d4\Nette\Utils\Strings;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use Symplify\PackageBuilder\Configuration\StaticEolConfiguration;
final class InlineVariableDocBlockMalformWorker extends \Symplify\CodingStandard\TokenRunner\DocBlock\MalformWorker\AbstractMalformWorker
{
    /**
     * @var string
     * @see https://regex101.com/r/GkyV1C/1
     */
    private const SINGLE_ASTERISK_START_REGEX = '#^/\\*\\s+\\*(\\s+@var)#';
    /**
     * @var string
     * @see https://regex101.com/r/9cfhFI/1
     */
    private const SPACE_REGEX = '#\\s+#m';
    /**
     * @var string
     * @see https://regex101.com/r/VpTDCd/1
     */
    private const ASTERISK_LEFTOVERS_REGEX = '#(\\*\\*)(\\s+\\*)#';
    public function work(string $docContent, \PhpCsFixer\Tokenizer\Tokens $tokens, int $position) : string
    {
        if (!$this->isVariableComment($tokens, $position)) {
            return $docContent;
        }
        // more than 2 newlines - keep it
        if (\substr_count($docContent, \Symplify\PackageBuilder\Configuration\StaticEolConfiguration::getEolChar()) > 2) {
            return $docContent;
        }
        // asterisk start
        $docContent = \_PhpScoper0d0ee1ba46d4\Nette\Utils\Strings::replace($docContent, self::SINGLE_ASTERISK_START_REGEX, '/**$1');
        // inline
        $docContent = \_PhpScoper0d0ee1ba46d4\Nette\Utils\Strings::replace($docContent, self::SPACE_REGEX, ' ');
        // remove asterisk leftover
        return \_PhpScoper0d0ee1ba46d4\Nette\Utils\Strings::replace($docContent, self::ASTERISK_LEFTOVERS_REGEX, '$1');
    }
    private function isVariableComment(\PhpCsFixer\Tokenizer\Tokens $tokens, int $position) : bool
    {
        $nextPosition = $tokens->getNextMeaningfulToken($position);
        if ($nextPosition === null) {
            return \false;
        }
        $nextNextPosition = $tokens->getNextMeaningfulToken($nextPosition + 2);
        if ($nextNextPosition === null) {
            return \false;
        }
        /** @var Token $nextNextToken */
        $nextNextToken = $tokens[$nextNextPosition];
        if ($nextNextToken->isGivenKind([\T_STATIC, \T_FUNCTION])) {
            return \false;
        }
        // is inline variable
        /** @var Token $nextToken */
        $nextToken = $tokens[$nextPosition];
        return $nextToken->isGivenKind(\T_VARIABLE);
    }
}