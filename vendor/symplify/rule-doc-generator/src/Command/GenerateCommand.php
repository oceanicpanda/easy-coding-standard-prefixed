<?php

declare (strict_types=1);
namespace Symplify\RuleDocGenerator\Command;

use _PhpScopera4be459e5e3d\Symfony\Component\Console\Input\InputArgument;
use _PhpScopera4be459e5e3d\Symfony\Component\Console\Input\InputInterface;
use _PhpScopera4be459e5e3d\Symfony\Component\Console\Input\InputOption;
use _PhpScopera4be459e5e3d\Symfony\Component\Console\Output\OutputInterface;
use Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand;
use Symplify\PackageBuilder\Console\ShellCode;
use Symplify\RuleDocGenerator\DirectoryToMarkdownPrinter;
use Symplify\RuleDocGenerator\ValueObject\Option;
use Symplify\SmartFileSystem\SmartFileInfo;
final class GenerateCommand extends \Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand
{
    /**
     * @var DirectoryToMarkdownPrinter
     */
    private $directoryToMarkdownPrinter;
    public function __construct(\Symplify\RuleDocGenerator\DirectoryToMarkdownPrinter $directoryToMarkdownPrinter)
    {
        parent::__construct();
        $this->directoryToMarkdownPrinter = $directoryToMarkdownPrinter;
    }
    protected function configure() : void
    {
        $this->setDescription('Generated Markdown documentation based on documented rules found in directory');
        $this->addArgument(\Symplify\RuleDocGenerator\ValueObject\Option::PATHS, \_PhpScopera4be459e5e3d\Symfony\Component\Console\Input\InputArgument::REQUIRED | \_PhpScopera4be459e5e3d\Symfony\Component\Console\Input\InputArgument::IS_ARRAY, 'Path to directory of your project');
        $this->addOption(\Symplify\RuleDocGenerator\ValueObject\Option::OUTPUT_FILE, null, \_PhpScopera4be459e5e3d\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Path to output generated markdown file', \getcwd() . '/docs/rules_overview.md');
    }
    protected function execute(\_PhpScopera4be459e5e3d\Symfony\Component\Console\Input\InputInterface $input, \_PhpScopera4be459e5e3d\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $paths = (array) $input->getArgument(\Symplify\RuleDocGenerator\ValueObject\Option::PATHS);
        $markdownFileContent = $this->directoryToMarkdownPrinter->print($paths);
        // dump markdown file
        $outputFilePath = (string) $input->getOption(\Symplify\RuleDocGenerator\ValueObject\Option::OUTPUT_FILE);
        $this->smartFileSystem->dumpFile($outputFilePath, $markdownFileContent);
        $outputFileInfo = new \Symplify\SmartFileSystem\SmartFileInfo($outputFilePath);
        $message = \sprintf('File "%s" was created', $outputFileInfo->getRelativeFilePathFromCwd());
        $this->symfonyStyle->success($message);
        return \Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
    }
}
