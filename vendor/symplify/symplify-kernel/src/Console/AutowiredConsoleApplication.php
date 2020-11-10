<?php

declare (strict_types=1);
namespace Symplify\SymplifyKernel\Console;

use _PhpScopere5e7dca8c031\Symfony\Component\Console\Command\Command;
final class AutowiredConsoleApplication extends \Symplify\SymplifyKernel\Console\AbstractSymplifyConsoleApplication
{
    /**
     * @param Command[] $commands
     */
    public function __construct(array $commands, string $name = 'UNKNOWN', string $version = 'UNKNOWN')
    {
        parent::__construct($commands, $name, $version);
    }
}
