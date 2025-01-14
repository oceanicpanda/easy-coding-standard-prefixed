<?php

declare (strict_types=1);
namespace Symplify\EasyCodingStandard\Console\Command;

use _PhpScoper78e1a27e740b\Symfony\Component\Console\Input\InputArgument;
use _PhpScoper78e1a27e740b\Symfony\Component\Console\Input\InputInterface;
use _PhpScoper78e1a27e740b\Symfony\Component\Console\Input\InputOption;
use _PhpScoper78e1a27e740b\Symfony\Component\Console\Output\OutputInterface;
use Symplify\EasyCodingStandard\Application\EasyCodingStandardApplication;
use Symplify\EasyCodingStandard\Configuration\Configuration;
use Symplify\EasyCodingStandard\Console\Output\ConsoleOutputFormatter;
use Symplify\EasyCodingStandard\Console\Style\EasyCodingStandardStyle;
use Symplify\EasyCodingStandard\Guard\LoadedCheckersGuard;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand;
abstract class AbstractCheckCommand extends AbstractSymplifyCommand
{
    /**
     * @var Configuration
     */
    protected $configuration;
    /**
     * @var EasyCodingStandardStyle
     */
    protected $easyCodingStandardStyle;
    /**
     * @var EasyCodingStandardApplication
     */
    protected $easyCodingStandardApplication;
    /**
     * @var LoadedCheckersGuard
     */
    private $loadedCheckersGuard;
    /**
     * @required
     */
    public function autowireAbstractCheckCommand(Configuration $configuration, EasyCodingStandardApplication $easyCodingStandardApplication, EasyCodingStandardStyle $easyCodingStandardStyle, LoadedCheckersGuard $loadedCheckersGuard) : void
    {
        $this->configuration = $configuration;
        $this->easyCodingStandardApplication = $easyCodingStandardApplication;
        $this->easyCodingStandardStyle = $easyCodingStandardStyle;
        $this->loadedCheckersGuard = $loadedCheckersGuard;
    }
    protected function configure() : void
    {
        $this->addArgument(
            Option::PATHS,
            // optional is on purpose here, since path from ecs.php can se ubsed
            InputArgument::OPTIONAL | InputArgument::IS_ARRAY,
            'The path(s) to be checked.'
        );
        $this->addOption(Option::FIX, null, null, 'Fix found violations.');
        $this->addOption(Option::CLEAR_CACHE, null, null, 'Clear cache for already checked files.');
        $this->addOption(Option::NO_PROGRESS_BAR, null, InputOption::VALUE_NONE, 'Hide progress bar. Useful e.g. for nicer CI output.');
        $this->addOption(Option::NO_ERROR_TABLE, null, InputOption::VALUE_NONE, 'Hide error table. Useful e.g. for fast check of error count.');
        $this->addOption(Option::OUTPUT_FORMAT, null, InputOption::VALUE_REQUIRED, 'Select output format', ConsoleOutputFormatter::NAME);
        $this->addOption(Option::MATCH_GIT_DIFF, null, InputOption::VALUE_NONE, 'Execute only on file(s) matching the git diff.');
    }
    protected function initialize(InputInterface $input, OutputInterface $output) : void
    {
        $this->loadedCheckersGuard->ensureSomeCheckersAreRegistered();
    }
}
