<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperd79d87c3336e\Symfony\Component\Console\Command;

use _PhpScoperd79d87c3336e\Symfony\Component\Console\Helper\DescriptorHelper;
use _PhpScoperd79d87c3336e\Symfony\Component\Console\Input\InputArgument;
use _PhpScoperd79d87c3336e\Symfony\Component\Console\Input\InputDefinition;
use _PhpScoperd79d87c3336e\Symfony\Component\Console\Input\InputInterface;
use _PhpScoperd79d87c3336e\Symfony\Component\Console\Input\InputOption;
use _PhpScoperd79d87c3336e\Symfony\Component\Console\Output\OutputInterface;
/**
 * ListCommand displays the list of all available commands for the application.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ListCommand extends \_PhpScoperd79d87c3336e\Symfony\Component\Console\Command\Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('list')->setDefinition($this->createDefinition())->setDescription('Lists commands')->setHelp(<<<'EOF'
The <info>%command.name%</info> command lists all commands:

  <info>php %command.full_name%</info>

You can also display the commands for a specific namespace:

  <info>php %command.full_name% test</info>

You can also output the information in other formats by using the <comment>--format</comment> option:

  <info>php %command.full_name% --format=xml</info>

It's also possible to get raw list of commands (useful for embedding command runner):

  <info>php %command.full_name% --raw</info>
EOF
);
    }
    /**
     * {@inheritdoc}
     */
    public function getNativeDefinition()
    {
        return $this->createDefinition();
    }
    /**
     * {@inheritdoc}
     */
    protected function execute(\_PhpScoperd79d87c3336e\Symfony\Component\Console\Input\InputInterface $input, \_PhpScoperd79d87c3336e\Symfony\Component\Console\Output\OutputInterface $output)
    {
        $helper = new \_PhpScoperd79d87c3336e\Symfony\Component\Console\Helper\DescriptorHelper();
        $helper->describe($output, $this->getApplication(), ['format' => $input->getOption('format'), 'raw_text' => $input->getOption('raw'), 'namespace' => $input->getArgument('namespace')]);
        return 0;
    }
    private function createDefinition() : \_PhpScoperd79d87c3336e\Symfony\Component\Console\Input\InputDefinition
    {
        return new \_PhpScoperd79d87c3336e\Symfony\Component\Console\Input\InputDefinition([new \_PhpScoperd79d87c3336e\Symfony\Component\Console\Input\InputArgument('namespace', \_PhpScoperd79d87c3336e\Symfony\Component\Console\Input\InputArgument::OPTIONAL, 'The namespace name'), new \_PhpScoperd79d87c3336e\Symfony\Component\Console\Input\InputOption('raw', null, \_PhpScoperd79d87c3336e\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'To output raw command list'), new \_PhpScoperd79d87c3336e\Symfony\Component\Console\Input\InputOption('format', null, \_PhpScoperd79d87c3336e\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'The output format (txt, xml, json, or md)', 'txt')]);
    }
}
