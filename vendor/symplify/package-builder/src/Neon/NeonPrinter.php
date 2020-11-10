<?php

declare (strict_types=1);
namespace Symplify\PackageBuilder\Neon;

use _PhpScoper0c236037eb04\Nette\Neon\Encoder;
use _PhpScoper0c236037eb04\Nette\Neon\Neon;
use _PhpScoper0c236037eb04\Nette\Utils\Strings;
final class NeonPrinter
{
    /**
     * @see https://regex101.com/r/r8DGyV/1
     * @var string
     */
    private const TAGS_REGEX = '#tags:\\s+\\-\\s+(?<tag>.*?)$#ms';
    /**
     * @see https://regex101.com/r/KjekIe/1
     * @var string
     */
    private const ARGUMENTS_DOUBLE_SPACE_REGEX = '#\\n(\\n\\s+arguments:)#ms';
    /**
     * @param mixed[] $phpStanNeon
     */
    public function printNeon(array $phpStanNeon) : string
    {
        $neonContent = \_PhpScoper0c236037eb04\Nette\Neon\Neon::encode($phpStanNeon, \_PhpScoper0c236037eb04\Nette\Neon\Encoder::BLOCK);
        // tabs to spaces for consistency
        $neonContent = $this->replaceTabsWithSpaces($neonContent);
        // inline single tags, dummy
        $neonContent = $this->inlineSingleTags($neonContent);
        $neonContent = $this->fixDoubleSpaceInArguments($neonContent);
        return \rtrim($neonContent) . \PHP_EOL;
    }
    private function replaceTabsWithSpaces(string $neonContent) : string
    {
        return \_PhpScoper0c236037eb04\Nette\Utils\Strings::replace($neonContent, '#\\t#', '    ');
    }
    private function inlineSingleTags(string $neonContent) : string
    {
        return \_PhpScoper0c236037eb04\Nette\Utils\Strings::replace($neonContent, self::TAGS_REGEX, 'tags: [$1]');
    }
    private function fixDoubleSpaceInArguments(string $neonContent) : string
    {
        return \_PhpScoper0c236037eb04\Nette\Utils\Strings::replace($neonContent, self::ARGUMENTS_DOUBLE_SPACE_REGEX, '$1');
    }
}