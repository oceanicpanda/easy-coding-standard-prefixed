<?php

/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace PhpCsFixer\Linter;

use _PhpScoper78e1a27e740b\Symfony\Component\Process\Process;
/**
 * @author Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * @internal
 */
final class ProcessLintingResult implements \PhpCsFixer\Linter\LintingResultInterface
{
    /**
     * @var bool
     */
    private $isSuccessful;
    /**
     * @var Process
     */
    private $process;
    /**
     * @var null|string
     */
    private $path;
    /**
     * @param null|string $path
     */
    public function __construct(Process $process, $path = null)
    {
        $this->process = $process;
        $this->path = $path;
    }
    /**
     * {@inheritdoc}
     */
    public function check()
    {
        if (!$this->isSuccessful()) {
            // on some systems stderr is used, but on others, it's not
            throw new \PhpCsFixer\Linter\LintingException($this->getProcessErrorMessage(), $this->process->getExitCode());
        }
    }
    private function getProcessErrorMessage()
    {
        $output = \strtok(\ltrim($this->process->getErrorOutput() ?: $this->process->getOutput()), "\n");
        if (\false === $output) {
            return 'Fatal error: Unable to lint file.';
        }
        if (null !== $this->path) {
            $needle = \sprintf('in %s ', $this->path);
            $pos = \strrpos($output, $needle);
            if (\false !== $pos) {
                $output = \sprintf('%s%s', \substr($output, 0, $pos), \substr($output, $pos + \strlen($needle)));
            }
        }
        $prefix = \substr($output, 0, 18);
        if ('PHP Parse error:  ' === $prefix) {
            return \sprintf('Parse error: %s.', \substr($output, 18));
        }
        if ('PHP Fatal error:  ' === $prefix) {
            return \sprintf('Fatal error: %s.', \substr($output, 18));
        }
        return \sprintf('%s.', $output);
    }
    private function isSuccessful()
    {
        if (null === $this->isSuccessful) {
            $this->process->wait();
            $this->isSuccessful = $this->process->isSuccessful();
        }
        return $this->isSuccessful;
    }
}
