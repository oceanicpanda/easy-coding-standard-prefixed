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
namespace PhpCsFixer\Console\Command;

use PhpCsFixer\Documentation\DocumentationGenerator;
use PhpCsFixer\FixerFactory;
use PhpCsFixer\RuleSet\RuleSets;
use _PhpScoper78e1a27e740b\Symfony\Component\Console\Command\Command;
use _PhpScoper78e1a27e740b\Symfony\Component\Console\Input\InputInterface;
use _PhpScoper78e1a27e740b\Symfony\Component\Console\Output\OutputInterface;
use _PhpScoper78e1a27e740b\Symfony\Component\Filesystem\Filesystem;
use _PhpScoper78e1a27e740b\Symfony\Component\Finder\Finder;
use _PhpScoper78e1a27e740b\Symfony\Component\Finder\SplFileInfo;
/**
 * @internal
 */
final class DocumentationCommand extends Command
{
    protected static $defaultName = 'documentation';
    /**
     * @var DocumentationGenerator
     */
    private $generator;
    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->generator = new DocumentationGenerator();
    }
    protected function configure()
    {
        $this->setAliases(['doc'])->setDescription('Dumps the documentation of the project into its /doc directory.');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fixerFactory = new FixerFactory();
        $fixerFactory->registerBuiltInFixers();
        $fixers = $fixerFactory->getFixers();
        $this->generateFixersDocs($fixers);
        $this->generateRuleSetsDocs($fixers);
        $output->writeln('Docs updated.');
        return 0;
    }
    private function generateFixersDocs(array $fixers)
    {
        $filesystem = new Filesystem();
        // Array of existing fixer docs.
        // We first override existing files, and then we will delete files that are no longer needed.
        // We cannot remove all files first, as generation of docs is re-using existing docs to extract code-samples for
        // VersionSpecificCodeSample under incompatible PHP version.
        $docForFixerRelativePaths = [];
        foreach ($fixers as $fixer) {
            $docForFixerRelativePaths[] = $this->generator->getFixerDocumentationFileRelativePath($fixer);
            $filesystem->dumpFile($this->generator->getFixerDocumentationFilePath($fixer), $this->generator->generateFixerDocumentation($fixer));
        }
        /** @var SplFileInfo $file */
        foreach ((new Finder())->files()->in($this->generator->getFixersDocumentationDirectoryPath())->notPath($docForFixerRelativePaths) as $file) {
            $filesystem->remove($file->getPathname());
        }
        $index = $this->generator->getFixersDocumentationIndexFilePath();
        if (\false === @\file_put_contents($index, $this->generator->generateFixersDocumentationIndex($fixers))) {
            throw new \RuntimeException("Failed updating file {$index}.");
        }
    }
    private function generateRuleSetsDocs(array $fixers)
    {
        $filesystem = new Filesystem();
        /** @var SplFileInfo $file */
        foreach ((new Finder())->files()->in($this->generator->getRuleSetsDocumentationDirectoryPath()) as $file) {
            $filesystem->remove($file->getPathname());
        }
        $index = $this->generator->getRuleSetsDocumentationIndexFilePath();
        $paths = [];
        foreach (RuleSets::getSetDefinitions() as $name => $definition) {
            $paths[$name] = $path = $this->generator->getRuleSetsDocumentationFilePath($name);
            $filesystem->dumpFile($path, $this->generator->generateRuleSetsDocumentation($definition, $fixers));
        }
        if (\false === @\file_put_contents($index, $this->generator->generateRuleSetsDocumentationIndex($paths))) {
            throw new \RuntimeException("Failed updating file {$index}.");
        }
    }
}
