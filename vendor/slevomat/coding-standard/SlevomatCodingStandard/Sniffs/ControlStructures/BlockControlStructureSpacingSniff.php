<?php

declare (strict_types=1);
namespace SlevomatCodingStandard\Sniffs\ControlStructures;

use PHP_CodeSniffer\Files\File;
use SlevomatCodingStandard\Helpers\SniffSettingsHelper;
use SlevomatCodingStandard\Helpers\TokenHelper;
use function array_key_exists;
use const T_CASE;
use const _PhpScoper48b5ec5b60cf\T_CLOSE_CURLY_BRACKET;
use const T_DEFAULT;
use const T_DO;
use const T_FOR;
use const T_FOREACH;
use const T_IF;
use const T_SWITCH;
use const T_TRY;
use const T_WHILE;
class BlockControlStructureSpacingSniff extends \SlevomatCodingStandard\Sniffs\ControlStructures\AbstractControlStructureSpacing
{
    /** @var int */
    public $linesCountBeforeControlStructure = 1;
    /** @var int */
    public $linesCountBeforeFirstControlStructure = 0;
    /** @var int */
    public $linesCountAfterControlStructure = 1;
    /** @var int */
    public $linesCountAfterLastControlStructure = 0;
    /** @var string[] */
    public $tokensToCheck = [];
    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     * @param File $phpcsFile
     * @param int $controlStructurePointer
     */
    public function process(\PHP_CodeSniffer\Files\File $phpcsFile, $controlStructurePointer) : void
    {
        if ($this->isWhilePartOfDo($phpcsFile, $controlStructurePointer)) {
            return;
        }
        parent::process($phpcsFile, $controlStructurePointer);
    }
    /**
     * @return int[]
     */
    protected function getSupportedTokens() : array
    {
        return [\T_IF, \T_DO, \T_WHILE, \T_FOR, \T_FOREACH, \T_SWITCH, \T_TRY, \T_CASE, \T_DEFAULT];
    }
    /**
     * @return string[]
     */
    protected function getTokensToCheck() : array
    {
        return $this->tokensToCheck;
    }
    protected function getLinesCountBefore() : int
    {
        return \SlevomatCodingStandard\Helpers\SniffSettingsHelper::normalizeInteger($this->linesCountBeforeControlStructure);
    }
    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     * @param File $phpcsFile
     * @param int $controlStructurePointer
     * @return int
     */
    protected function getLinesCountBeforeFirst(\PHP_CodeSniffer\Files\File $phpcsFile, int $controlStructurePointer) : int
    {
        return \SlevomatCodingStandard\Helpers\SniffSettingsHelper::normalizeInteger($this->linesCountBeforeFirstControlStructure);
    }
    protected function getLinesCountAfter() : int
    {
        return \SlevomatCodingStandard\Helpers\SniffSettingsHelper::normalizeInteger($this->linesCountAfterControlStructure);
    }
    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     * @param File $phpcsFile
     * @param int $controlStructurePointer
     * @param int $controlStructureEndPointer
     * @return int
     */
    protected function getLinesCountAfterLast(\PHP_CodeSniffer\Files\File $phpcsFile, int $controlStructurePointer, int $controlStructureEndPointer) : int
    {
        return \SlevomatCodingStandard\Helpers\SniffSettingsHelper::normalizeInteger($this->linesCountAfterLastControlStructure);
    }
    private function isWhilePartOfDo(\PHP_CodeSniffer\Files\File $phpcsFile, int $controlStructurePointer) : bool
    {
        $tokens = $phpcsFile->getTokens();
        $pointerBefore = \SlevomatCodingStandard\Helpers\TokenHelper::findPreviousEffective($phpcsFile, $controlStructurePointer - 1);
        return $tokens[$controlStructurePointer]['code'] === \T_WHILE && $tokens[$pointerBefore]['code'] === \T_CLOSE_CURLY_BRACKET && \array_key_exists('scope_condition', $tokens[$pointerBefore]) && $tokens[$tokens[$pointerBefore]['scope_condition']]['code'] === \T_DO;
    }
}
