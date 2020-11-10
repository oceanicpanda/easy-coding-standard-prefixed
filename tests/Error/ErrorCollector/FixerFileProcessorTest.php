<?php

declare (strict_types=1);
namespace Symplify\EasyCodingStandard\Tests\Error\ErrorCollector;

use Symplify\EasyCodingStandard\Error\ErrorAndDiffCollector;
use Symplify\EasyCodingStandard\FixerRunner\Application\FixerFileProcessor;
use Symplify\EasyCodingStandard\HttpKernel\EasyCodingStandardKernel;
use Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
final class FixerFileProcessorTest extends \Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var ErrorAndDiffCollector
     */
    private $errorAndDiffCollector;
    /**
     * @var FixerFileProcessor
     */
    private $fixerFileProcessor;
    protected function setUp() : void
    {
        $this->bootKernelWithConfigs(\Symplify\EasyCodingStandard\HttpKernel\EasyCodingStandardKernel::class, [__DIR__ . '/FixerRunnerSource/phpunit-fixer-config.php']);
        $this->errorAndDiffCollector = self::$container->get(\Symplify\EasyCodingStandard\Error\ErrorAndDiffCollector::class);
        $this->fixerFileProcessor = self::$container->get(\Symplify\EasyCodingStandard\FixerRunner\Application\FixerFileProcessor::class);
    }
    public function test() : void
    {
        $this->runFileProcessor();
        $this->assertCount(0, $this->errorAndDiffCollector->getErrors());
        $this->assertCount(1, $this->errorAndDiffCollector->getFileDiffs());
    }
    private function runFileProcessor() : void
    {
        $fileInfo = new \Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/ErrorCollectorSource/NotPsr2Class.php.inc');
        $this->fixerFileProcessor->processFile($fileInfo);
    }
}
