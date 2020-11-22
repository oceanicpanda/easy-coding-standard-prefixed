<?php

declare (strict_types=1);
namespace Symplify\EasyCodingStandard\SnippetFormatter\Command;

use _PhpScoperf3db63c305b2\Symfony\Component\Console\Input\InputInterface;
use Symplify\EasyCodingStandard\Console\Command\AbstractCheckCommand;
use Symplify\EasyCodingStandard\SnippetFormatter\Formatter\SnippetFormatter;
use Symplify\PackageBuilder\Console\ShellCode;
use Symplify\SmartFileSystem\Finder\SmartFinder;
use Symplify\SmartFileSystem\SmartFileInfo;
use Symplify\SmartFileSystem\SmartFileSystem;
abstract class AbstractSnippetFormatterCommand extends \Symplify\EasyCodingStandard\Console\Command\AbstractCheckCommand
{
    /**
     * @var SnippetFormatter
     */
    private $snippetFormatter;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    /**
     * @var SmartFinder
     */
    private $smartFinder;
    /**
     * @required
     */
    public function autowireAbstractSnippetFormatterCommand(\Symplify\EasyCodingStandard\SnippetFormatter\Formatter\SnippetFormatter $snippetFormatter, \Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \Symplify\SmartFileSystem\Finder\SmartFinder $smartFinder) : void
    {
        $this->snippetFormatter = $snippetFormatter;
        $this->smartFileSystem = $smartFileSystem;
        $this->smartFinder = $smartFinder;
    }
    protected function doExecuteSnippetFormatterWithFileNamesAndSnippetPattern(\_PhpScoperf3db63c305b2\Symfony\Component\Console\Input\InputInterface $input, string $fileNames, string $snippetPattern, string $kind) : int
    {
        $this->configuration->resolveFromInput($input);
        $sources = $this->configuration->getSources();
        $phpFileInfos = $this->smartFinder->find($sources, $fileNames, ['Fixture']);
        $fileCount = \count($phpFileInfos);
        if ($fileCount === 0) {
            return $this->printNoFilesFoundWarningAndExitSuccess($sources, $fileNames);
        }
        $this->easyCodingStandardStyle->progressStart($fileCount);
        foreach ($phpFileInfos as $phpFileInfo) {
            $this->processFileInfoWithPattern($phpFileInfo, $snippetPattern, $kind);
            $this->easyCodingStandardStyle->progressAdvance();
        }
        return $this->reportProcessedFiles($fileCount);
    }
    private function processFileInfoWithPattern(\Symplify\SmartFileSystem\SmartFileInfo $phpFileInfo, string $snippetPattern, string $kind) : void
    {
        $fixedContent = $this->snippetFormatter->format($phpFileInfo, $snippetPattern, $kind);
        if ($phpFileInfo->getContents() === $fixedContent) {
            // nothing has changed
            return;
        }
        if (!$this->configuration->isFixer()) {
            return;
        }
        $this->smartFileSystem->dumpFile($phpFileInfo->getPathname(), $fixedContent);
    }
    /**
     * @param string[] $sources
     */
    private function printNoFilesFoundWarningAndExitSuccess(array $sources, string $type) : int
    {
        $warningMessage = \sprintf('No "%s" files found in "%s" paths.%sCheck CLI arguments or "Option::PATHS" parameter in "ecs.php" config file', $type, \implode('", ', $sources), \PHP_EOL);
        $this->easyCodingStandardStyle->warning($warningMessage);
        return \Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
    }
}
