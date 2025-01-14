<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper78e1a27e740b\Symfony\Component\Console\Event;

use _PhpScoper78e1a27e740b\Symfony\Component\Console\Command\Command;
use _PhpScoper78e1a27e740b\Symfony\Component\Console\Input\InputInterface;
use _PhpScoper78e1a27e740b\Symfony\Component\Console\Output\OutputInterface;
/**
 * Allows to manipulate the exit code of a command after its execution.
 *
 * @author Francesco Levorato <git@flevour.net>
 */
final class ConsoleTerminateEvent extends \_PhpScoper78e1a27e740b\Symfony\Component\Console\Event\ConsoleEvent
{
    private $exitCode;
    public function __construct(Command $command, InputInterface $input, OutputInterface $output, int $exitCode)
    {
        parent::__construct($command, $input, $output);
        $this->setExitCode($exitCode);
    }
    public function setExitCode(int $exitCode) : void
    {
        $this->exitCode = $exitCode;
    }
    public function getExitCode() : int
    {
        return $this->exitCode;
    }
}
