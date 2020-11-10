<?php

declare (strict_types=1);
namespace Symplify\EasyCodingStandard\SnippetFormatter\Formatter;

use _PhpScoper48800f361566\Nette\Utils\Strings;
use Symplify\EasyCodingStandard\FixerRunner\Application\FixerFileProcessor;
use Symplify\EasyCodingStandard\SniffRunner\Application\SniffFileProcessor;
use Symplify\EasyCodingStandard\SnippetFormatter\Provider\CurrentParentFileInfoProvider;
use Symplify\SmartFileSystem\SmartFileInfo;
use Symplify\SmartFileSystem\SmartFileSystem;
use Throwable;
/**
 * @see \Symplify\EasyCodingStandard\SnippetFormatter\Tests\Markdown\MarkdownSnippetFormatterTest
 * @see \Symplify\EasyCodingStandard\SnippetFormatter\Tests\HeredocNowdoc\HereNowDocSnippetFormatterTest
 */
final class SnippetFormatter
{
    /**
     * @see https://regex101.com/r/MJTq5C/1
     * @var string
     */
    private const DECLARE_REGEX = '#(declare\\(strict\\_types\\=1\\)\\;\\s+)#ms';
    /**
     * @see https://regex101.com/r/MJTq5C/3
     * @var string
     */
    private const OPENING_TAG_REGEX = '#^\\<\\?php\\n#ms';
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    /**
     * @var FixerFileProcessor
     */
    private $fixerFileProcessor;
    /**
     * @var SniffFileProcessor
     */
    private $sniffFileProcessor;
    /**
     * @var CurrentParentFileInfoProvider
     */
    private $currentParentFileInfoProvider;
    /**
     * @var bool
     */
    private $isPhp73OrAbove;
    public function __construct(\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \Symplify\EasyCodingStandard\FixerRunner\Application\FixerFileProcessor $fixerFileProcessor, \Symplify\EasyCodingStandard\SniffRunner\Application\SniffFileProcessor $sniffFileProcessor, \Symplify\EasyCodingStandard\SnippetFormatter\Provider\CurrentParentFileInfoProvider $currentParentFileInfoProvider)
    {
        $this->smartFileSystem = $smartFileSystem;
        $this->fixerFileProcessor = $fixerFileProcessor;
        $this->sniffFileProcessor = $sniffFileProcessor;
        $this->currentParentFileInfoProvider = $currentParentFileInfoProvider;
        $this->isPhp73OrAbove = \PHP_VERSION_ID >= 70300;
    }
    public function format(\Symplify\SmartFileSystem\SmartFileInfo $fileInfo, string $snippetRegex) : string
    {
        $this->currentParentFileInfoProvider->setParentFileInfo($fileInfo);
        return (string) \_PhpScoper48800f361566\Nette\Utils\Strings::replace($fileInfo->getContents(), $snippetRegex, function ($match) : string {
            if (\_PhpScoper48800f361566\Nette\Utils\Strings::contains($match['content'], '-----')) {
                // do nothing
                return $match['opening'] . $match['content'] . $match['closing'];
            }
            return $this->fixContentAndPreserveFormatting($match);
        });
    }
    /**
     * @param string[] $match
     */
    private function fixContentAndPreserveFormatting(array $match) : string
    {
        if ($this->isPhp73OrAbove) {
            return \str_replace(\PHP_EOL, '', $match['opening']) . \PHP_EOL . $this->fixContent($match['content']) . \str_replace(\PHP_EOL, '', $match['closing']);
        }
        return \rtrim($match['opening'], \PHP_EOL) . \PHP_EOL . $this->fixContent($match['content']) . \ltrim($match['closing'], \PHP_EOL);
    }
    private function fixContent(string $content) : string
    {
        $content = $this->isPhp73OrAbove ? $content : \trim($content);
        $temporaryFilePath = $this->createTemporaryFilePath($content);
        if (!\_PhpScoper48800f361566\Nette\Utils\Strings::startsWith($this->isPhp73OrAbove ? \trim($content) : $content, '<?php')) {
            $content = '<?php' . \PHP_EOL . $content;
        }
        $fileContent = $this->isPhp73OrAbove ? \ltrim($content, \PHP_EOL) : $content;
        $this->smartFileSystem->dumpFile($temporaryFilePath, $fileContent);
        $temporaryFileInfo = new \Symplify\SmartFileSystem\SmartFileInfo($temporaryFilePath);
        try {
            $this->fixerFileProcessor->processFile($temporaryFileInfo);
            $this->sniffFileProcessor->processFile($temporaryFileInfo);
            $fileContent = $temporaryFileInfo->getContents();
        } catch (\Throwable $throwable) {
            // Skipped parsed error when processing php temporaryFile
        } finally {
            // remove temporary temporaryFile
            $this->smartFileSystem->remove($temporaryFilePath);
        }
        $fileContent = \rtrim($fileContent, \PHP_EOL) . \PHP_EOL;
        if ($this->isPhp73OrAbove) {
            $fileContent = \ltrim($fileContent, \PHP_EOL);
        }
        return $this->removeOpeningTagAndStrictTypes($fileContent);
    }
    /**
     * It does not have any added value and only clutters the output
     */
    private function removeOpeningTagAndStrictTypes(string $content) : string
    {
        $content = \_PhpScoper48800f361566\Nette\Utils\Strings::replace($content, self::DECLARE_REGEX, '');
        return \_PhpScoper48800f361566\Nette\Utils\Strings::replace($content, self::OPENING_TAG_REGEX, '$1');
    }
    private function createTemporaryFilePath(string $content) : string
    {
        $key = \md5($content);
        $fileName = \sprintf('php-code-%s.php', $key);
        return \sys_get_temp_dir() . \DIRECTORY_SEPARATOR . 'ecs_temp' . \DIRECTORY_SEPARATOR . $fileName;
    }
}
